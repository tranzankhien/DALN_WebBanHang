<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of user's orders (Order History)
     */
    public function index()
    {
        $orders = Order::with(['items.product.images', 'payment'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order details
     */
    public function show($id)
    {
        $order = Order::with([
            'items.product.images',
            'items.inventoryItem.category',
            'items.inventoryItem.attributeValues.attribute',
            'payment'
        ])
        ->where('user_id', Auth::id())
        ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order
     */
    public function cancel(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        // Check if order can be cancelled
        if (!$order->isCancellable()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ Không thể hủy đơn hàng ở trạng thái này!'
                ], 422);
            }
            return back()->with('error', '⚠️ Không thể hủy đơn hàng ở trạng thái này!');
        }

        $validated = $request->validate([
            'cancel_reason' => 'required|string|max:500',
        ]);

        // Update order status to cancelled
        $order->update([
            'status' => 'cancelled',
            'cancel_reason' => $validated['cancel_reason'],
            'cancelled_at' => now(),
        ]);

        // Update payment status if exists
        if ($order->payment) {
            $order->payment->update(['status' => 'failed']);
        }

        // Restore product stock
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => '✅ Đã hủy đơn hàng thành công!'
            ]);
        }

        return redirect()->route('orders.index')
            ->with('success', '✅ Đã hủy đơn hàng thành công!');
    }

    /**
     * Retry payment for an unpaid order
     */
    public function retryPayment(Request $request, $id)
    {
        $order = Order::with(['payment', 'items.product', 'items.inventoryItem.attributeValues.attribute'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        // Verify order can be paid
        if ($order->status === 'cancelled') {
            return back()->with('error', '⚠️ Không thể thanh toán cho đơn hàng đã hủy!');
        }

        if (!$order->payment) {
            return back()->with('error', '⚠️ Không tìm thấy thông tin thanh toán!');
        }

        if (!in_array($order->payment->status, ['pending', 'failed'])) {
            return back()->with('error', '⚠️ Đơn hàng này đã được thanh toán!');
        }

        // Prepare checkout data from order
        $checkoutData = [
            'shipping_name' => $order->shipping_name,
            'shipping_phone' => $order->shipping_phone,
            'shipping_email' => $order->user->email,
            'shipping_address' => $order->shipping_address,
            'shipping_ward' => $order->shipping_ward,
            'shipping_district' => $order->shipping_district,
            'shipping_city' => $order->shipping_city,
            'customer_note' => $order->customer_note,
            'payment_method' => $order->payment->method,
        ];

        // Store checkout data and retry flag in session
        $request->session()->put('checkout_data', $checkoutData);
        $request->session()->put('retry_payment_order_id', $order->id);

        // Prepare cart items data for checkout form
        $cartItems = $order->items->map(function($item) {
            return [
                'product' => $item->product,
                'inventoryItem' => $item->inventoryItem,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ];
        });

        $request->session()->put('retry_cart_items', $cartItems->toArray());

        // Redirect to checkout form (not review) so user can change payment method
        return redirect()->route('checkout.index');
    }
}


