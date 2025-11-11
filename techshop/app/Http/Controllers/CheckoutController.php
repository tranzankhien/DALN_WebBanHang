<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display checkout page
     */
    public function index()
    {
        $cart = $this->getCart();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', '⚠️ Giỏ hàng của bạn đang trống!');
        }

        $cartItems = $cart->items()->with(['product.images'])->get();
        
        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            $price = $item->product->discount_price ?? $item->product->price;
            return $price * $item->quantity;
        });
        
        $shippingFee = 30000; // 30,000 VND flat shipping
        $total = $subtotal + $shippingFee;

        // Get user's default address if authenticated
        $defaultAddress = null;
        if (Auth::check()) {
            $defaultAddress = Auth::user()->addresses()->where('is_default', true)->first();
        }

        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingFee', 'total', 'defaultAddress'));
    }

    /**
     * Display order confirmation page (review before placing order)
     */
    public function review(Request $request)
    {
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:100',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'nullable|string|max:100',
            'shipping_district' => 'nullable|string|max:100',
            'shipping_ward' => 'nullable|string|max:100',
            'customer_note' => 'nullable|string|max:500',
            'payment_method' => 'required|in:cod,bank_transfer',
        ]);

        $cart = $this->getCart();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', '⚠️ Giỏ hàng của bạn đang trống!');
        }

        $cartItems = $cart->items()->with(['product.images'])->get();
        
        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            $price = $item->product->discount_price ?? $item->product->price;
            return $price * $item->quantity;
        });
        
        $shippingFee = 30000;
        $total = $subtotal + $shippingFee;

        // Store in session temporarily
        session(['checkout_data' => $validated]);

        return view('checkout.review', compact('cartItems', 'subtotal', 'shippingFee', 'total', 'validated'));
    }

    /**
     * Place the order
     */
    public function placeOrder(Request $request)
    {
        // Get checkout data from session
        $checkoutData = session('checkout_data');
        
        if (!$checkoutData) {
            return redirect()->route('checkout.index')->with('error', '⚠️ Vui lòng nhập thông tin giao hàng!');
        }

        $cart = $this->getCart();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', '⚠️ Giỏ hàng của bạn đang trống!');
        }

        DB::beginTransaction();
        
        try {
            $cartItems = $cart->items()->with('product')->get();
            
            // Verify stock availability
            foreach ($cartItems as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Sản phẩm '{$item->product->name}' không đủ hàng trong kho!");
                }
            }
            
            // Calculate total
            $subtotal = $cartItems->sum(function($item) {
                $price = $item->product->discount_price ?? $item->product->price;
                return $price * $item->quantity;
            });
            
            $shippingFee = 30000;
            $total = $subtotal + $shippingFee;

            // Create order
            $order = Order::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_name' => $checkoutData['shipping_name'],
                'shipping_phone' => $checkoutData['shipping_phone'],
                'shipping_address' => $checkoutData['shipping_address'],
                'shipping_city' => $checkoutData['shipping_city'] ?? null,
                'shipping_district' => $checkoutData['shipping_district'] ?? null,
                'shipping_ward' => $checkoutData['shipping_ward'] ?? null,
                'customer_note' => $checkoutData['customer_note'] ?? null,
            ]);

            // Create order items and reduce stock
            foreach ($cartItems as $item) {
                $price = $item->product->discount_price ?? $item->product->price;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'inventory_item_id' => $item->product->inventory_item_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
                ]);

                // Reduce product stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'method' => $checkoutData['payment_method'],
                'amount' => $total,
                'status' => 'pending',
                'transaction_id' => null,
            ]);

            // Clear cart
            $cart->items()->delete();

            // Clear checkout session data
            session()->forget('checkout_data');

            DB::commit();

            return redirect()->route('checkout.success', ['order' => $order->id])
                ->with('success', '✅ Đặt hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('checkout.index')
                ->with('error', '⚠️ Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display order success page
     */
    public function success($orderId)
    {
        $order = Order::with(['items.product.images', 'payment'])->findOrFail($orderId);
        
        // Verify order belongs to current user (if authenticated)
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * Get cart for current user/session
     */
    private function getCart()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->first();
        } else {
            $sessionId = session()->getId();
            return Cart::where('session_id', $sessionId)->first();
        }
    }
}
