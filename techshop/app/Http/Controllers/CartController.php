<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\CartItem;

class CartController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return view('cart.cart', [
                'cartItems' => collect(),
                'subtotal' => 0,
                'totalQuantity' => 0,
                'forceLoginPopup' => true,
            ]);
        }

        $user = $request->user();
        $cart = $user->cart()->firstOrCreate([]);

        // Drop orphan cart items if their product is missing
        $cart->items()->whereDoesntHave('product')->delete();

        $cartItems = $cart->items()->with('product.images')->get();

        $subtotal = $cartItems->reduce(function ($carry, CartItem $item) {
            if (!$item->product) {
                return $carry;
            }

            $price = $item->product->discount_price ?? $item->product->price;
            return $carry + (float) $price * $item->quantity;
        }, 0.0);

        return view('cart.cart', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'totalQuantity' => $cartItems->sum('quantity'),
            'forceLoginPopup' => false,
        ]);
    }

    public function add(Request $request)
    {
        if (!Auth::check()) {
            return $this->unauthenticatedResponse($request);
        }

        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

    $product = Product::find($data['product_id']);

        if (!$product || (int) $product->stock <= 0) {
            return back()->withErrors(['product_id' => 'Sản phẩm tạm hết hàng.'])->withInput();
        }

        $user = $request->user();

        $message = 'Sản phẩm đã được thêm vào giỏ hàng.';
        $addedQuantity = 0;

        DB::transaction(function () use ($user, $product, $data, &$message, &$addedQuantity) {
            $cart = $user->cart()->firstOrCreate([]);
            $cartItem = $cart->items()->firstOrNew(['product_id' => $product->id]);

            $currentQty = $cartItem->exists ? $cartItem->quantity : 0;
            $available = max((int) $product->stock, 0);
            $maxAddable = max($available - $currentQty, 0);

            if ($maxAddable <= 0) {
                $message = 'Bạn đã có số lượng tối đa cho sản phẩm này trong giỏ hàng.';
                return;
            }

            $add = min($data['quantity'], $maxAddable);
            $cartItem->quantity = $currentQty + $add;
            $cartItem->save();

            if ($add < $data['quantity']) {
                $message = 'Chỉ thêm được ' . $add . ' sản phẩm do giới hạn tồn kho.';
            }

            $addedQuantity = $add;
        });

        if ($addedQuantity <= 0) {
            return redirect()->route('cart.index')->with('warning', $message);
        }

        return redirect()->route('cart.index')->with('status', $message);
    }

    public function update(Request $request, CartItem $item)
    {
        $this->authorizeItem($item);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = $item->product;

        if (!$product || (int) $product->stock <= 0) {
            $item->delete();
            return redirect()->route('cart.index')->with('warning', 'Sản phẩm không còn khả dụng và đã được xóa khỏi giỏ hàng.');
        }

        $available = max((int) $product->stock, 0);
        $newQuantity = min($data['quantity'], $available);

        if ($newQuantity < $data['quantity']) {
            $item->update(['quantity' => $newQuantity]);
            return redirect()->route('cart.index')->with('warning', 'Số lượng đã được giới hạn theo tồn kho hiện có.');
        }

        $item->update(['quantity' => $newQuantity]);

        return redirect()->route('cart.index')->with('status', 'Cập nhật số lượng thành công.');
    }

    public function destroy(CartItem $item)
    {
        $this->authorizeItem($item);
        $item->delete();

        return redirect()->route('cart.index')->with('status', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    protected function unauthenticatedResponse(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Bạn cần đăng nhập để sử dụng giỏ hàng.'], 401);
        }

        return back()->with('forceLoginPopup', true);
    }

    protected function authorizeItem(CartItem $item): void
    {
        $item->loadMissing('cart');

        if (!Auth::check() || $item->cart?->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
