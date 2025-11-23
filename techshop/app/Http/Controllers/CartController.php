<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart->items()->with([
            'product.images', 
            'product.inventoryItem.attributeValues.attribute'
        ])->get();
        
        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            $price = $item->product->discount_price ?? $item->product->price;
            return $price * $item->quantity;
        });
        
        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Check stock
        if ($product->stock < $request->quantity) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ Số lượng sản phẩm không đủ trong kho!'
                ], 422);
            }
            return back()->with('error', '⚠️ Số lượng sản phẩm không đủ trong kho!');
        }

        $cart = $this->getOrCreateCart();

        // Check if product already in cart
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            if ($newQuantity > $product->stock) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => '⚠️ Số lượng vượt quá tồn kho!'
                    ], 422);
                }
                return back()->with('error', '⚠️ Số lượng vượt quá tồn kho!');
            }
            
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Add new item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->discount_price ?? $product->price,
            ]);
        }

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            $cartCount = $cart->items()->sum('quantity');
            return response()->json([
                'success' => true,
                'message' => '✅ Đã thêm sản phẩm vào giỏ hàng!',
                'count' => $cartCount
            ]);
        }

        return redirect()->route('cart.index')->with('success', '✅ Đã thêm sản phẩm vào giỏ hàng!');
    }

    /**
     * Buy now - Add to cart and redirect to checkout
     */
    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Check stock
        if ($product->stock < $request->quantity) {
            return back()->with('error', '⚠️ Số lượng sản phẩm không đủ trong kho!');
        }

        // Store buy now info in session (don't add to cart yet)
        session([
            'buy_now' => [
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->discount_price ?? $product->price,
            ]
        ]);

        // Redirect directly to checkout
        return redirect()->route('checkout.index');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();
        $cartItem = $cart->items()->findOrFail($itemId);

        // Check stock
        if ($cartItem->product->stock < $request->quantity) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ Số lượng vượt quá tồn kho!'
                ], 422);
            }
            return back()->with('error', '⚠️ Số lượng vượt quá tồn kho!');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            $price = $cartItem->product->discount_price ?? $cartItem->product->price;
            return response()->json([
                'success' => true,
                'message' => '✅ Đã cập nhật số lượng!',
                'item' => [
                    'id' => $cartItem->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $price,
                    'total' => $price * $cartItem->quantity
                ]
            ]);
        }

        return back()->with('success', '✅ Đã cập nhật số lượng!');
    }

    /**
     * Remove item from cart
     */
    public function remove($itemId)
    {
        $cart = $this->getOrCreateCart();
        $cartItem = $cart->items()->findOrFail($itemId);
        $cartItem->delete();

        return back()->with('success', '✅ Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->delete();

        return back()->with('success', '✅ Đã xóa toàn bộ giỏ hàng!');
    }

    /**
     * Get or create cart for current user/session
     */
    private function getOrCreateCart()
    {
        if (!Auth::check()) {
            abort(401, 'Vui lòng đăng nhập để sử dụng giỏ hàng.');
        }

        return Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['session_id' => null]
        );
    }

    /**
     * Get cart item count for header badge
     */
    public function count()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $cart = $this->getOrCreateCart();
        $count = $cart->items()->sum('quantity');
        
        return response()->json(['count' => $count]);
    }
}
