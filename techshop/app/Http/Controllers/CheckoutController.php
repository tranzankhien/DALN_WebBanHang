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
    public function index(Request $request)
    {
        // Check if this is a retry payment
        if (session()->has('retry_payment_order_id')) {
            $orderId = session('retry_payment_order_id');
            $order = Order::with(['items.product.images', 'items.inventoryItem.category', 'items.inventoryItem.attributeValues.attribute'])
                ->findOrFail($orderId);

            $cartItems = $order->items;
            $subtotal = $order->total_amount - 30000;
            $shippingFee = 30000;
            $total = $order->total_amount;
            
            // Get checkout data from session (with existing info)
            $checkoutData = session('checkout_data', []);
            $defaultAddress = null;
            $isBuyNow = false;

            return view('checkout.index', compact('cartItems', 'subtotal', 'shippingFee', 'total', 'defaultAddress', 'isBuyNow', 'checkoutData'));
        }
        
        // Check if this is a "Buy Now" checkout
        if (session()->has('buy_now')) {
            $buyNowData = session('buy_now');
            $product = Product::with('images')->findOrFail($buyNowData['product_id']);
            
            // Check stock again
            if ($product->stock < $buyNowData['quantity']) {
                session()->forget('buy_now');
                return redirect()->back()->with('error', '⚠️ Sản phẩm không đủ hàng trong kho!');
            }
            
            // Create a temporary cart item structure for the view
            $cartItems = collect([
                (object)[
                    'id' => 'buy_now',
                    'product' => $product,
                    'quantity' => $buyNowData['quantity'],
                    'price' => $buyNowData['price'],
                ]
            ]);
            
            $isBuyNow = true;
        } else {
            // Regular cart checkout - only selected items
            $cart = $this->getCart();
            
            if (!$cart || $cart->items->isEmpty()) {
                return redirect()->route('cart.index')->with('error', '⚠️ Giỏ hàng của bạn đang trống!');
            }

            // Get selected items from request
            if ($request->has('selected_items')) {
                $selectedItemIds = json_decode($request->input('selected_items'), true);
                
                if (empty($selectedItemIds)) {
                    return redirect()->route('cart.index')->with('error', '⚠️ Vui lòng chọn sản phẩm cần mua!');
                }
                
                // Store selected items in session for later use
                session(['selected_cart_items' => $selectedItemIds]);
                
                $cartItems = $cart->items()->with(['product.images'])
                    ->whereIn('id', $selectedItemIds)
                    ->get();
            } elseif (session()->has('selected_cart_items')) {
                // Use previously selected items from session
                $selectedItemIds = session('selected_cart_items');
                $cartItems = $cart->items()->with(['product.images'])
                    ->whereIn('id', $selectedItemIds)
                    ->get();
            } else {
                return redirect()->route('cart.index')->with('error', '⚠️ Vui lòng chọn sản phẩm cần mua!');
            }
            
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', '⚠️ Không tìm thấy sản phẩm đã chọn!');
            }

            $isBuyNow = false;
        }
        
        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            $price = $item->price ?? ($item->product->discount_price ?? $item->product->price);
            return $price * $item->quantity;
        });
        
        $shippingFee = 30000; // 30,000 VND flat shipping
        $total = $subtotal + $shippingFee;

        // Get user's default address if authenticated
        $defaultAddress = null;
        if (Auth::check()) {
            $defaultAddress = Auth::user()->addresses()->where('is_default', true)->first();
        }

        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingFee', 'total', 'defaultAddress', 'isBuyNow'));
    }

    /**
     * Display order confirmation page (review before placing order)
     */
    public function review(Request $request)
    {
        // Check if this is an AJAX request to update shipping info
        if ($request->isMethod('post') && $request->ajax()) {
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
            
            // Update session checkout_data
            session(['checkout_data' => $validated]);
            
            return response()->json(['success' => true, 'message' => 'Đã cập nhật thông tin']);
        }
        
        // Check if this is a retry payment
        if (session()->has('retry_payment_order_id')) {
            $orderId = session('retry_payment_order_id');
            $order = Order::with(['items.product.images', 'items.inventoryItem.category', 'items.inventoryItem.attributeValues.attribute'])
                ->findOrFail($orderId);

            $cartItems = $order->items;
            $subtotal = $order->total_amount - 30000; // Subtract shipping fee
            $shippingFee = 30000;
            $total = $order->total_amount;
            
            $checkoutData = session('checkout_data');
            $validated = $checkoutData; // Use checkout data for the form
            $isBuyNow = false;

            return view('checkout.review', compact('cartItems', 'subtotal', 'shippingFee', 'total', 'validated', 'isBuyNow'));
        }

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

        // Check if this is a "Buy Now" checkout
        if (session()->has('buy_now')) {
            $buyNowData = session('buy_now');
            $product = Product::with('images')->findOrFail($buyNowData['product_id']);
            
            // Check stock again
            if ($product->stock < $buyNowData['quantity']) {
                session()->forget('buy_now');
                return redirect()->route('home')->with('error', '⚠️ Sản phẩm không đủ hàng trong kho!');
            }
            
            // Create a temporary cart item structure for the view
            $cartItems = collect([
                (object)[
                    'id' => 'buy_now',
                    'product' => $product,
                    'quantity' => $buyNowData['quantity'],
                    'price' => $buyNowData['price'],
                ]
            ]);
            
            $isBuyNow = true;
        } else {
            // Regular cart checkout - only selected items
            $cart = $this->getCart();
            
            if (!$cart || $cart->items->isEmpty()) {
                return redirect()->route('cart.index')->with('error', '⚠️ Giỏ hàng của bạn đang trống!');
            }

            // Get selected items from session
            if (session()->has('selected_cart_items')) {
                $selectedItemIds = session('selected_cart_items');
                $cartItems = $cart->items()->with(['product.images'])
                    ->whereIn('id', $selectedItemIds)
                    ->get();
                
                if ($cartItems->isEmpty()) {
                    return redirect()->route('cart.index')->with('error', '⚠️ Không tìm thấy sản phẩm đã chọn!');
                }
            } else {
                return redirect()->route('cart.index')->with('error', '⚠️ Vui lòng chọn sản phẩm cần mua!');
            }

            $isBuyNow = false;
        }
        
        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            $price = $item->price ?? ($item->product->discount_price ?? $item->product->price);
            return $price * $item->quantity;
        });
        
        $shippingFee = 30000;
        $total = $subtotal + $shippingFee;

        // Store in session temporarily
        session(['checkout_data' => $validated]);

        return view('checkout.review', compact('cartItems', 'subtotal', 'shippingFee', 'total', 'validated', 'isBuyNow'));
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

        DB::beginTransaction();
        
        try {
            // Check if this is a retry payment - skip order creation
            if (session()->has('retry_payment_order_id')) {
                $orderId = session('retry_payment_order_id');
                $order = Order::findOrFail($orderId);

                // Update payment method if changed
                if ($order->payment && $checkoutData['payment_method'] !== $order->payment->method) {
                    $order->payment->update([
                        'method' => $checkoutData['payment_method'],
                        'status' => 'pending',
                    ]);
                }

                DB::commit();

                // If payment method is bank_transfer, process VNPay payment directly
                if ($checkoutData['payment_method'] === 'bank_transfer') {
                    // Create VNPay payment request
                    $request->merge(['order_id' => $order->id, 'bank_code' => '']);
                    return $this->vnpayPayment($request);
                }

                // For COD, update order status and go to success page
                $order->update(['status' => 'confirmed']);
                $order->payment->update(['status' => 'paid']);

                // Clear retry session data
                session()->forget(['retry_payment_order_id', 'retry_cart_items', 'checkout_data']);

                return redirect()->route('checkout.success', ['order' => $order->id])
                    ->with('success', '✅ Đơn hàng đã được cập nhật!');
            }
            
            // Check if this is a "Buy Now" order
            if (session()->has('buy_now')) {
                $buyNowData = session('buy_now');
                $product = Product::findOrFail($buyNowData['product_id']);
                
                // Verify stock
                if ($product->stock < $buyNowData['quantity']) {
                    throw new \Exception("Sản phẩm '{$product->name}' không đủ hàng trong kho!");
                }
                
                // Create items collection for buy now
                $cartItems = collect([
                    (object)[
                        'product' => $product,
                        'product_id' => $product->id,
                        'quantity' => $buyNowData['quantity'],
                        'price' => $buyNowData['price'],
                    ]
                ]);
                
                $isBuyNow = true;
            } else {
                // Regular cart checkout - only selected items
                $cart = $this->getCart();
                
                if (!$cart || $cart->items->isEmpty()) {
                    return redirect()->route('cart.index')->with('error', '⚠️ Giỏ hàng của bạn đang trống!');
                }
                
                // Get selected items from session
                if (session()->has('selected_cart_items')) {
                    $selectedItemIds = session('selected_cart_items');
                    $cartItems = $cart->items()->with('product')
                        ->whereIn('id', $selectedItemIds)
                        ->get();
                    
                    if ($cartItems->isEmpty()) {
                        return redirect()->route('cart.index')->with('error', '⚠️ Không tìm thấy sản phẩm đã chọn!');
                    }
                } else {
                    return redirect()->route('cart.index')->with('error', '⚠️ Vui lòng chọn sản phẩm cần mua!');
                }
                
                $isBuyNow = false;
                
                // Verify stock availability for all selected items
                foreach ($cartItems as $item) {
                    if ($item->product->stock < $item->quantity) {
                        throw new \Exception("Sản phẩm '{$item->product->name}' không đủ hàng trong kho!");
                    }
                }
            }
            
            // Calculate total
            $subtotal = $cartItems->sum(function($item) {
                $price = $item->price ?? ($item->product->discount_price ?? $item->product->price);
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
                $price = $item->price ?? ($item->product->discount_price ?? $item->product->price);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'inventory_item_id' => $item->product->inventory_item_id ?? null,
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

            // Clear cart or buy now session
            if ($isBuyNow) {
                session()->forget('buy_now');
            } else {
                // Only delete selected items from cart
                if (session()->has('selected_cart_items')) {
                    $selectedItemIds = session('selected_cart_items');
                    $cart->items()->whereIn('id', $selectedItemIds)->delete();
                    session()->forget('selected_cart_items');
                } else {
                    // Fallback: delete all items (shouldn't happen with new logic)
                    $cart->items()->delete();
                }
            }

            // Clear checkout session data
            session()->forget('checkout_data');

            DB::commit();

            // If payment method is bank_transfer, process VNPay payment directly
            if ($checkoutData['payment_method'] === 'bank_transfer') {
                // Create VNPay payment request
                $request->merge(['order_id' => $order->id, 'bank_code' => '']);
                return $this->vnpayPayment($request);
            }

            // For COD, go directly to success page
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

    /**
     * Create VNPay payment URL and redirect user
     */
    public function vnpayPayment(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'bank_code' => 'nullable|string',
        ]);

        $order = Order::findOrFail($validated['order_id']);
        
        // Verify order belongs to current user
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Get VNPay config from services.php
        $vnpayConfig = config('services.vnpay');
        
        $vnp_TmnCode = $vnpayConfig['tmn_code'];
        $vnp_HashSecret = $vnpayConfig['hash_secret'];
        $vnp_Url = $vnpayConfig['url'];
        $vnp_ReturnUrl = $vnpayConfig['return_url'];
        
        // Prepare payment data
        $vnp_TxnRef = $order->id . '_' . time(); // Unique transaction reference
        $vnp_OrderInfo = 'Thanh toan don hang #' . $order->id . ' tai TechShop';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $order->total_amount * 100; // VNPay requires amount in VND * 100
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip();
        
        // Set timezone to Vietnam (GMT+7) for VNPay
        $vietnamTimezone = new \DateTimeZone('Asia/Ho_Chi_Minh');
        $createDate = new \DateTime('now', $vietnamTimezone);
        $expireDate = (clone $createDate)->modify('+30 minutes'); // Increase to 30 minutes
        
        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $createDate->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expireDate->format('YmdHis'),
        ];

        // Add bank code if provided
        if (!empty($validated['bank_code'])) {
            $inputData['vnp_BankCode'] = $validated['bank_code'];
        }

        // Sort parameters
        ksort($inputData);
        
        // Build query string and hash data
        $query = "";
        $hashdata = "";
        $i = 0;
        
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        // Create payment URL
        $vnp_Url = $vnp_Url . "?" . $query;
        
        if (!empty($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        
        // Update payment record with transaction reference
        $payment = Payment::where('order_id', $order->id)->first();
        if ($payment) {
            $payment->update([
                'transaction_id' => $vnp_TxnRef,
            ]);
        }
        
        // Log VNPay request for debugging
        \Log::info('VNPay Payment Request', [
            'order_id' => $order->id,
            'amount' => $vnp_Amount,
            'create_date' => $createDate->format('YmdHis'),
            'expire_date' => $expireDate->format('YmdHis'),
            'txn_ref' => $vnp_TxnRef,
        ]);
        
        // Redirect to VNPay
        return redirect($vnp_Url);
    }

    /**
     * Handle VNPay return callback
     */
    public function vnpayReturn(Request $request)
    {
        $vnpayConfig = config('services.vnpay');
        $vnp_HashSecret = $vnpayConfig['hash_secret'];
        
        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
        
        // Log VNPay response for debugging
        \Log::info('VNPay Return Callback', [
            'all_params' => $inputData,
            'response_code' => $request->vnp_ResponseCode ?? 'N/A',
            'txn_ref' => $request->vnp_TxnRef ?? 'N/A',
        ]);
        
        // Remove hash params
        unset($inputData['vnp_SecureHash']);
        unset($inputData['vnp_SecureHashType']);
        
        // Sort parameters
        ksort($inputData);
        
        // Build hash data
        $hashdata = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        
        $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        
        // Verify signature
        if ($secureHash !== $vnp_SecureHash) {
            return redirect()->route('orders.index')
                ->with('error', '⚠️ Chữ ký không hợp lệ! Giao dịch có thể bị giả mạo.');
        }
        
        // Get transaction info
        $vnp_TxnRef = $request->vnp_TxnRef;
        $vnp_ResponseCode = $request->vnp_ResponseCode;
        $vnp_TransactionNo = $request->vnp_TransactionNo ?? null;
        
        // Extract order ID from transaction reference
        $orderId = (int) explode('_', $vnp_TxnRef)[0];
        $order = Order::find($orderId);
        
        if (!$order) {
            return redirect()->route('orders.index')
                ->with('error', '⚠️ Không tìm thấy đơn hàng!');
        }
        
        // Update payment status based on response code
        $payment = Payment::where('order_id', $order->id)->first();
        
        if ($vnp_ResponseCode == '00') {
            // Payment successful
            if ($payment) {
                $payment->update([
                    'status' => 'paid',
                    'transaction_id' => $vnp_TransactionNo,
                    'paid_at' => now(),
                ]);
            }
            
            $order->update([
                'status' => 'confirmed',
            ]);
            
            // Clear retry payment session if exists
            session()->forget(['retry_payment_order_id', 'retry_payment_amount']);
            
            return redirect()->route('checkout.success', ['order' => $order->id])
                ->with('success', '✅ Thanh toán thành công! Đơn hàng của bạn đang được xử lý.');
        } else {
            // Payment failed
            if ($payment) {
                $payment->update([
                    'status' => 'failed',
                ]);
            }
            
            // Clear retry payment session if exists (but keep order_id for retry option)
            session()->forget(['retry_payment_order_id', 'retry_payment_amount']);
            
            // Get error message
            $errorMessages = [
                '07' => 'Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường).',
                '09' => 'Thẻ/Tài khoản chưa đăng ký dịch vụ InternetBanking tại ngân hàng.',
                '10' => 'Thẻ/Tài khoản không đủ số dư để thực hiện giao dịch.',
                '11' => 'Đã hết hạn chờ thanh toán.',
                '12' => 'Thẻ/Tài khoản bị khóa.',
                '13' => 'Sai mật khẩu xác thực giao dịch (OTP).',
                '24' => 'Khách hàng hủy giao dịch.',
                '51' => 'Tài khoản không đủ số dư để thực hiện giao dịch.',
                '65' => 'Tài khoản đã vượt quá hạn mức giao dịch trong ngày.',
                '75' => 'Ngân hàng thanh toán đang bảo trì.',
                '79' => 'Giao dịch vượt quá số lần nhập sai mật khẩu. Vui lòng thử lại sau.',
            ];
            
            $errorMessage = $errorMessages[$vnp_ResponseCode] ?? 'Giao dịch không thành công. Vui lòng thử lại hoặc chọn phương thức thanh toán khác.';
            
            return redirect()->route('orders.show', ['id' => $order->id])
                ->with('error', '⚠️ Thanh toán thất bại: ' . $errorMessage);
        }
    }

}
