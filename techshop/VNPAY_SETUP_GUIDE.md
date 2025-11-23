# 🔐 Hướng dẫn tích hợp VNPay Payment Gateway

## 📋 Tổng quan

VNPay là cổng thanh toán điện tử hàng đầu Việt Nam, hỗ trợ thanh toán qua:
- Thẻ ATM nội địa
- Thẻ tín dụng/ghi nợ quốc tế (Visa, Mastercard, JCB, etc.)
- Ví điện tử VNPay
- QR Code
- Internet Banking

## 🚀 Các bước thiết lập

### Bước 1: Đăng ký tài khoản VNPay

#### 1.1. Môi trường Sandbox (Test)
- Truy cập: https://sandbox.vnpayment.vn/
- Đăng ký tài khoản doanh nghiệp test
- Sau khi đăng ký, bạn sẽ nhận được:
  - **TMN Code** (Terminal Code): Mã định danh của merchant
  - **Hash Secret**: Khóa bí mật để tạo chữ ký

#### 1.2. Môi trường Production (Thực tế)
- Liên hệ VNPay: https://vnpay.vn/
- Ký hợp đồng và cung cấp giấy tờ doanh nghiệp
- Thời gian: 5-7 ngày làm việc
- Phí dịch vụ: ~1.5% - 2% mỗi giao dịch

### Bước 2: Cấu hình trong Laravel

#### 2.1. Thêm biến môi trường vào file `.env`

```env
# VNPay Configuration
VNPAY_TMN_CODE=your_vnpay_tmn_code_here
VNPAY_HASH_SECRET=your_vnpay_hash_secret_here
VNPAY_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNPAY_RETURN_URL=http://localhost:8000/checkout/vnpay-return
VNPAY_API_URL=https://sandbox.vnpayment.vn/merchant_webapi/api/transaction
```

**Lưu ý:** 
- Đối với Sandbox, sử dụng URL sandbox
- Đối với Production, đổi sang: `https://vnpay.vn/paymentv2/vpcpay.html`

#### 2.2. Cấu hình Return URL

Return URL là địa chỉ mà VNPay sẽ redirect user sau khi thanh toán:
- Development: `http://localhost:8000/checkout/vnpay-return`
- Production: `https://your-domain.com/checkout/vnpay-return`

**Quan trọng:** Return URL phải được đăng ký với VNPay trước khi sử dụng!

### Bước 3: Đăng ký Return URL với VNPay

1. Đăng nhập vào portal VNPay (sandbox hoặc production)
2. Vào mục **Cấu hình** → **Cấu hình IPN/Return URL**
3. Thêm Return URL của bạn
4. Lưu cấu hình

### Bước 4: Test thanh toán (Sandbox)

#### 4.1. Thẻ test

VNPay cung cấp các thẻ test để kiểm tra:

**Thẻ ATM nội địa (NCB):**
```
Số thẻ: 9704198526191432198
Tên: NGUYEN VAN A
Ngày phát hành: 07/15
Mật khẩu OTP: 123456
```

**Thẻ quốc tế:**
```
Số thẻ: 4111111111111111
Ngày hết hạn: 12/25
CVV: 123
```

#### 4.2. Quy trình test

1. Tạo đơn hàng trên website
2. Chọn phương thức "Chuyển khoản ngân hàng"
3. Click "Thanh toán qua VNPay"
4. Chọn ngân hàng (ví dụ: NCB)
5. Nhập thông tin thẻ test
6. Xác nhận OTP
7. Kiểm tra kết quả trả về

### Bước 5: Xử lý các trường hợp

#### 5.1. Giao dịch thành công
- Response Code: `00`
- Order status: `confirmed`
- Payment status: `completed`

#### 5.2. Giao dịch thất bại
Các mã lỗi phổ biến:
- `07`: Giao dịch nghi ngờ (fraud)
- `09`: Thẻ chưa đăng ký Internet Banking
- `10`: Không đủ số dư
- `11`: Hết hạn thanh toán (15 phút)
- `12`: Thẻ bị khóa
- `13`: Sai OTP
- `24`: Khách hàng hủy giao dịch
- `51`: Không đủ số dư
- `65`: Vượt hạn mức giao dịch
- `75`: Ngân hàng bảo trì
- `79`: Nhập sai quá nhiều lần

## 🔒 Bảo mật

### 1. Hash Secret
- **KHÔNG BAO GIỜ** commit Hash Secret vào Git
- Lưu trữ trong file `.env`
- Sử dụng `hash_hmac('sha512', ...)` để tạo chữ ký

### 2. Verify Signature
Hệ thống luôn verify chữ ký từ VNPay:
```php
$secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
if ($secureHash !== $vnp_SecureHash) {
    // Reject transaction - possible fraud
}
```

### 3. IP Whitelist
VNPay có thể yêu cầu whitelist IP server của bạn:
- Development: Không cần
- Production: Bắt buộc

## 📊 Flow thanh toán

```
User                Website             VNPay
  |                    |                  |
  |--[1] Chọn VNPay -->|                  |
  |                    |--[2] Tạo URL --->|
  |                    |                  |
  |<---[3] Redirect ---|                  |
  |------------------>[4] Nhập thẻ ----->|
  |                    |                  |
  |<------[5] Return URL with params-----|
  |                    |                  |
  |                    |<-[6] Verify -----|
  |<---[7] Success ----|                  |
```

**Chi tiết:**
1. User chọn thanh toán VNPay
2. Website tạo URL với params và signature
3. Redirect user đến VNPay
4. User nhập thông tin thẻ và OTP
5. VNPay redirect về Return URL với kết quả
6. Website verify signature
7. Hiển thị kết quả cho user

## 🛠️ Troubleshooting

### Lỗi: "Invalid Signature"
- Kiểm tra Hash Secret đúng chưa
- Đảm bảo params được sort theo alphabet
- Kiểm tra encoding (urlencode)

### Lỗi: "Return URL not match"
- Return URL phải đăng ký với VNPay trước
- Phải match chính xác (kể cả http/https)

### Lỗi: "Transaction Timeout"
- VNPay giới hạn 15 phút
- Sau 15 phút giao dịch tự động hủy

### Giao dịch pending
- Kiểm tra IPN URL (nếu có)
- Có thể query trạng thái qua API

## 📝 Testing Checklist

- [ ] Giao dịch thành công
- [ ] Giao dịch thất bại (không đủ tiền)
- [ ] Timeout (chờ quá 15 phút)
- [ ] User hủy giữa chừng
- [ ] Verify signature đúng
- [ ] Verify signature sai (fake request)
- [ ] Cập nhật order status
- [ ] Cập nhật payment status
- [ ] Giảm stock khi thanh toán thành công
- [ ] Email notification (nếu có)

## 🌐 API Endpoints

### Website Endpoints
- `GET /checkout/vnpay-payment` - Hiển thị trang chọn ngân hàng
- `POST /checkout/vnpay-payment` - Tạo URL và redirect đến VNPay
- `GET /checkout/vnpay-return` - Nhận callback từ VNPay

### VNPay Endpoints (Sandbox)
- Payment: `https://sandbox.vnpayment.vn/paymentv2/vpcpay.html`
- Query API: `https://sandbox.vnpayment.vn/merchant_webapi/api/transaction`

### VNPay Endpoints (Production)
- Payment: `https://vnpay.vn/paymentv2/vpcpay.html`
- Query API: `https://vnpay.vn/merchant_webapi/api/transaction`

## 📚 Tài liệu tham khảo

- VNPay Sandbox: https://sandbox.vnpayment.vn/
- VNPay Documentation: https://sandbox.vnpayment.vn/apis/
- VNPay Support: support@vnpay.vn
- Hotline: 1900 55 55 77

## 💡 Best Practices

1. **Logging**: Log tất cả transactions để debug
2. **Error Handling**: Xử lý đầy đủ các error codes
3. **User Experience**: Hiển thị loading khi redirect
4. **Timeout Handling**: Xử lý trường hợp user không về Return URL
5. **Reconciliation**: Đối soát giao dịch định kỳ với VNPay
6. **Testing**: Test kỹ trước khi lên production

## ⚠️ Lưu ý quan trọng

1. **Môi trường Production**:
   - Phải ký hợp đồng với VNPay
   - Thay đổi URL từ sandbox sang production
   - Whitelist IP server
   - Test kỹ trước khi go-live

2. **Bảo mật**:
   - Không log Hash Secret
   - Luôn verify signature
   - Validate amount và order_id

3. **User Experience**:
   - Thông báo rõ ràng về timeout 15 phút
   - Cung cấp link "Quay lại" nếu user muốn đổi phương thức
   - Hiển thị loading indicator khi redirect

4. **Đối soát**:
   - VNPay cung cấp file đối soát hàng ngày
   - Nên tự động hóa process đối soát
   - Xử lý các giao dịch lệch (pending, dispute)

## 🎯 Kết luận

Tích hợp VNPay hoàn tất! Các bước tiếp theo:

1. ✅ Cấu hình `.env` với credentials từ VNPay
2. ✅ Đăng ký Return URL với VNPay
3. ✅ Test với thẻ sandbox
4. ✅ Kiểm tra tất cả flow (success, fail, timeout)
5. ✅ Chuẩn bị lên production

**Support**: Nếu cần hỗ trợ, liên hệ VNPay hoặc check documentation.
