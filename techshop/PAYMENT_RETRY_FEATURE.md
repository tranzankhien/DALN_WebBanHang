# Payment Retry Feature Implementation

## Overview
Added payment retry functionality for orders with pending or failed payment status. Users can now complete payment for unpaid orders directly from the order details page.

## Changes Made

### 1. Frontend - Order Details Page
**File:** `resources/views/orders/show.blade.php`

**Changes:**
- Added "Thanh toán ngay" (Pay Now) button in payment section
- Button appears only when:
  - Payment status is `pending` or `failed`
  - Payment method is `bank_transfer` (VNPay)
  - Order status is not `cancelled`
- Button submits form to `orders.retry-payment` route

### 2. Routes
**File:** `routes/web.php`

**Changes:**
- Added new route: `POST /orders/{id}/retry-payment`
- Route name: `orders.retry-payment`
- Protected by `auth` and `verified` middleware

### 3. Order Controller
**File:** `app/Http/Controllers/OrderController.php`

**New Method:** `retryPayment($id)`
- Validates order belongs to authenticated user
- Checks order status (cannot retry if cancelled)
- Verifies payment exists and method is `bank_transfer`
- Validates payment status is `pending` or `failed`
- Stores retry payment info in session:
  - `retry_payment_order_id`: Order ID to retry
  - `retry_payment_amount`: Total amount
- Redirects to VNPay payment page

### 4. Checkout Controller
**File:** `app/Http/Controllers/CheckoutController.php`

**Modified Methods:**

#### `showVnpayPayment()`
- Added support for retry payment session
- Checks for `retry_payment_order_id` in session
- Loads order and passes to view
- Sets `order_id` in session for payment processing
- Falls back to normal flow if no retry session

#### `vnpayReturn()`
- Added session cleanup for retry payments
- Clears `retry_payment_order_id` and `retry_payment_amount` after success
- Clears retry session on failure to allow new retry attempts

### 5. Payment View
**File:** `resources/views/checkout/vnpay-payment.blade.php`

**Changes:**
- Updated to handle both new orders and retry payments
- Checks for `$order` variable or session `order_id`
- Dynamically displays order information
- Works seamlessly for both scenarios

## User Flow

### Payment Retry Flow:
1. User views order details with pending/failed payment
2. Clicks "Thanh toán ngay" button
3. System validates:
   - Order exists and belongs to user
   - Order not cancelled
   - Payment method is bank_transfer
   - Payment status allows retry
4. User redirected to VNPay payment page
5. User selects bank and proceeds to VNPay
6. After payment:
   - **Success**: Payment status → `completed`, Order status → `confirmed`
   - **Failure**: Payment status → `failed`, user can retry again

## Payment Status States

| Status | Description | Can Retry? |
|--------|-------------|-----------|
| `pending` | Payment not yet completed | ✅ Yes |
| `failed` | Payment failed or cancelled | ✅ Yes |
| `completed` | Payment successful | ❌ No |

## Security Features

1. **User Verification**: Orders can only be paid by their owner
2. **Status Validation**: Prevents payment for cancelled orders
3. **Method Restriction**: Only supports VNPay retry (bank_transfer)
4. **Session Management**: Secure session handling for payment flow
5. **Payment Integrity**: VNPay signature verification ensures security

## Error Handling

| Error | Message | Action |
|-------|---------|--------|
| Order cancelled | Không thể thanh toán cho đơn hàng đã hủy | Redirect to order details |
| No payment info | Không tìm thấy thông tin thanh toán | Redirect to order details |
| Wrong payment method | Chỉ hỗ trợ thanh toán lại cho phương thức chuyển khoản | Redirect to order details |
| Already paid | Đơn hàng này đã được thanh toán | Redirect to order details |

## Testing Scenarios

### Test Case 1: Successful Payment Retry
1. Create order with bank_transfer payment
2. Cancel payment at VNPay page
3. Return to order details
4. Verify "Thanh toán ngay" button appears
5. Click button and complete payment
6. Verify payment status → `completed`
7. Verify button disappears

### Test Case 2: Failed Payment Retry
1. Create order with bank_transfer payment
2. Let payment timeout at VNPay
3. Return to order details
4. Verify payment status → `failed`
5. Click "Thanh toán ngay"
6. Cancel payment again
7. Verify can retry multiple times

### Test Case 3: COD Order
1. Create order with COD payment
2. View order details
3. Verify "Thanh toán ngay" button does NOT appear

### Test Case 4: Cancelled Order
1. Create order with bank_transfer
2. Cancel order
3. View order details
4. Verify "Thanh toán ngay" button does NOT appear

### Test Case 5: Completed Payment
1. Complete payment for order
2. View order details
3. Verify "Thanh toán ngay" button does NOT appear

## VNPay Error Codes Handled

| Code | Message |
|------|---------|
| 00 | Giao dịch thành công |
| 07 | Giao dịch bị nghi ngờ (lừa đảo) |
| 09 | Chưa đăng ký InternetBanking |
| 10 | Không đủ số dư |
| 11 | Hết hạn chờ thanh toán |
| 12 | Thẻ/Tài khoản bị khóa |
| 13 | Sai mật khẩu OTP |
| 24 | Khách hàng hủy giao dịch |
| 51 | Tài khoản không đủ số dư |
| 65 | Vượt quá hạn mức giao dịch |
| 75 | Ngân hàng bảo trì |
| 79 | Vượt quá số lần nhập sai mật khẩu |

## Session Variables Used

| Variable | Purpose | Cleared On |
|----------|---------|-----------|
| `retry_payment_order_id` | Store order ID for retry | Success/Failure |
| `retry_payment_amount` | Store payment amount | Success/Failure |
| `order_id` | Current order being processed | Success |

## Files Modified Summary

1. ✅ `resources/views/orders/show.blade.php` - Added payment button
2. ✅ `routes/web.php` - Added retry-payment route
3. ✅ `app/Http/Controllers/OrderController.php` - Added retryPayment() method
4. ✅ `app/Http/Controllers/CheckoutController.php` - Modified showVnpayPayment() and vnpayReturn()
5. ✅ `resources/views/checkout/vnpay-payment.blade.php` - Updated to handle retry payments

## Benefits

1. **Improved UX**: Users don't need to create new orders for failed payments
2. **Reduced Cart Clutter**: No duplicate orders from payment failures
3. **Better Conversion**: Easier path to complete purchases
4. **Transaction History**: Maintains order history integrity
5. **Flexible**: Users can retry multiple times until success

## Future Enhancements

1. Add payment timeout countdown on payment page
2. Send email notification when payment fails with retry link
3. Add payment history log for each retry attempt
4. Support retry for other payment methods (not just VNPay)
5. Add payment reminder notifications after X hours

---

**Implementation Date:** 2025-01-XX  
**Status:** ✅ Complete and Tested  
**Version:** 1.0
