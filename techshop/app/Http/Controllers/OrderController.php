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
}

