# ✅ VNPay Payment Gateway - Đã tích hợp xong

## 📋 Thông tin đã cấu hình

### **Môi trường:** SANDBOX (Test)
### **Ngày nhận thông tin:** 23/11/2025

---

## 🔐 Thông tin xác thực

```env
Terminal ID (vnp_TmnCode): 4J7YLYDU
Secret Key (vnp_HashSecret): VW69DMADZWLXO65FL77Y19GYDY47DPN5
Payment URL: https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
Return URL: http://localhost:8000/checkout/vnpay-return
```

---

## 🏦 Truy cập VNPay Merchant Admin

**Quản lý giao dịch:**
- **URL:** https://sandbox.vnpayment.vn/merchantv2/
- **Username:** 22014013@st.phenikaa-uni.edu.vn
- **Password:** Tranzankhien16122004

**Test Case/SIT:**
- **URL:** https://sandbox.vnpayment.vn/vnpaygw-sit-testing/user/login
- **Username:** 22014013@st.phenikaa-uni.edu.vn
- **Password:** Tranzankhien16122004

---

## 💳 Thẻ test

Sử dụng thông tin thẻ sau để test thanh toán:

| Thông tin | Giá trị |
|-----------|---------|
| **Ngân hàng** | NCB |
| **Số thẻ** | `9704198526191432198` |
| **Tên chủ thẻ** | NGUYEN VAN A |
| **Ngày phát hành** | 07/15 |
| **Mật khẩu OTP** | `123456` |

---

## 🧪 Hướng dẫn test thanh toán

### **Bước 1: Khởi động server**

```bash
# Terminal 1: Laravel
php artisan serve

# Terminal 2: Vite (frontend)
npm run dev
```

Server sẽ chạy tại: http://localhost:8000

---

### **Bước 2: Tạo đơn hàng test**

1. Truy cập: http://localhost:8000
2. Đăng nhập hoặc đăng ký tài khoản
3. Xác thực email (kiểm tra log hoặc Mailtrap)
4. Thêm sản phẩm vào giỏ hàng
5. Vào giỏ hàng: http://localhost:8000/cart
6. Click "Thanh toán"

---

### **Bước 3: Checkout với VNPay**

1. Điền thông tin giao hàng:
   - Họ tên
   - Số điện thoại
   - Địa chỉ
   - Thành phố, Quận/Huyện, Phường/Xã

2. Chọn phương thức thanh toán: **"Chuyển khoản ngân hàng"**

3. Click "Xác nhận đơn hàng"

4. Bạn sẽ được redirect đến trang VNPay

---

### **Bước 4: Thanh toán trên VNPay**

1. Chọn **Ngân hàng NCB** trong danh sách
2. Nhập thông tin thẻ test:
   - Số thẻ: `9704198526191432198`
   - Tên: `NGUYEN VAN A`
   - Ngày phát hành: `07/15`
3. Click "Tiếp tục"
4. Nhập OTP: `123456`
5. Xác nhận thanh toán

---

### **Bước 5: Kiểm tra kết quả**

**Thanh toán thành công:**
- Redirect về: http://localhost:8000/checkout/vnpay-return
- Order status: `paid`
- Hiển thị thông báo thành công
- Check database: `orders` table

**Hủy thanh toán:**
- Redirect về với thông báo lỗi
- Order status: `cancelled` hoặc `pending`

---

## 📊 Test cases cần kiểm tra

| Test Case | Hành động | Kết quả mong đợi |
|-----------|-----------|------------------|
| **TC01** | Thanh toán thành công | Order saved, status = `paid`, redirect success page |
| **TC02** | Nhấn "Hủy" trên VNPay | Order status = `cancelled`, thông báo hủy |
| **TC03** | Nhập sai OTP 3 lần | Thông báo lỗi, không tạo order |
| **TC04** | Timeout thanh toán | Order status = `pending`, thông báo timeout |
| **TC05** | Signature không hợp lệ | Reject request, log error |

---

## 🔍 Debug và kiểm tra

### **1. Kiểm tra config đã load đúng:**

```bash
php artisan tinker
```

```php
config('services.vnpay')
// Kết quả phải trả về:
[
  "tmn_code" => "4J7YLYDU",
  "hash_secret" => "VW69DMADZWLXO65FL77Y19GYDY47DPN5",
  "url" => "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html",
  "return_url" => "http://localhost:8000/checkout/vnpay-return",
  "api_url" => "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction",
]
```

---

### **2. Kiểm tra logs:**

```bash
tail -f storage/logs/laravel.log
```

Khi thanh toán, bạn sẽ thấy:
- Request parameters gửi đến VNPay
- Response từ VNPay return URL
- Signature verification results
- Order creation/update logs

---

### **3. Kiểm tra database:**

```sql
-- Xem orders vừa tạo
SELECT id, user_id, total_amount, payment_method, status, vnpay_transaction_id, created_at 
FROM orders 
ORDER BY created_at DESC 
LIMIT 5;

-- Xem order items
SELECT oi.*, p.name as product_name
FROM order_items oi
JOIN products p ON oi.product_id = p.id
WHERE oi.order_id = [order_id_vừa_tạo];
```

---

## 📱 Demo VNPay

Nếu muốn test trước khi tích hợp:
- **Demo URL:** https://sandbox.vnpayment.vn/apis/vnpay-demo/
- Dùng thẻ test NCB để xem flow thanh toán

---

## 🔗 Tài liệu tham khảo

| Tài liệu | URL |
|----------|-----|
| **API Documentation** | https://sandbox.vnpayment.vn/apis/docs/thanh-toan-pay/pay.html |
| **Code Demo** | https://sandbox.vnpayment.vn/apis/vnpay-demo/code-demo-tích-hợp |
| **Merchant Admin** | https://sandbox.vnpayment.vn/merchantv2/ |
| **Test Cases** | https://sandbox.vnpayment.vn/vnpaygw-sit-testing/user/login |

---

## ⚠️ Lưu ý quan trọng

### **1. Môi trường Sandbox**
- Đây là môi trường TEST, KHÔNG dùng cho khách hàng thật
- Chỉ nhận thẻ test, không charge tiền thật
- Giao dịch sẽ tự động expire sau 15 phút

### **2. IPN URL (Server to Server)**
Cần cấu hình IPN URL trong VNPay Merchant Admin:
1. Đăng nhập: https://sandbox.vnpayment.vn/merchantv2/
2. Vào: **Cấu hình** → **IPN URL**
3. Nhập: `http://localhost:8000/checkout/vnpay-return`
4. Lưu lại

**Lưu ý:** Khi deploy lên production, phải đổi thành domain thật!

### **3. Bảo mật**
- ✅ LUÔN verify signature từ VNPay
- ✅ Check order status trước khi cập nhật
- ✅ Log tất cả transactions để đối soát
- ❌ KHÔNG expose `vnp_HashSecret` ra ngoài
- ❌ KHÔNG commit file `.env` lên Git

### **4. Production deployment**
Khi lên production:
```env
# Đổi URL từ sandbox → production
VNPAY_URL=https://vnpayment.vn/paymentv2/vpcpay.html
VNPAY_API_URL=https://vnpayment.vn/merchant_webapi/api/transaction
VNPAY_RETURN_URL=https://your-domain.com/checkout/vnpay-return

# TMN_CODE và HASH_SECRET sẽ khác (VNPAY sẽ cấp)
```

---

## 🐛 Troubleshooting

### **Vấn đề 1: "Invalid signature"**
**Nguyên nhân:** Hash secret sai hoặc cách tính checksum không đúng

**Giải pháp:**
```bash
# Clear config
php artisan config:clear

# Check lại hash secret
php artisan tinker
config('services.vnpay.hash_secret')
```

---

### **Vấn đề 2: "URL return không hoạt động"**
**Nguyên nhân:** Route chưa được đăng ký hoặc middleware chặn

**Giải pháp:**
```bash
# Check route
php artisan route:list | grep vnpay

# Kết quả mong đợi:
# GET|HEAD checkout/vnpay-return ... CheckoutController@vnpayReturn
```

---

### **Vấn đề 3: "Order không được tạo"**
**Nguyên nhân:** Validation fail hoặc database error

**Giải pháp:**
```bash
# Check logs
tail -f storage/logs/laravel.log

# Check database connection
php artisan tinker
DB::connection()->getPdo()
```

---

## 📞 Liên hệ hỗ trợ

**VNPay Support:**
- **Email:** support.vnpayment@vnpay.vn
- **Hotline:** 1900 55 55 77

**Trường hợp cần hỗ trợ:**
- Không nhận được email thông tin tài khoản
- Quên mật khẩu Merchant Admin
- Lỗi kết nối hoặc signature mismatch
- Cần chuyển từ Sandbox → Production

---

## ✅ Checklist hoàn thành

### **Setup:**
- [x] Cập nhật `.env` với thông tin VNPay
- [x] Config `services.php` đã có VNPay section
- [x] Clear cache: config, route, view
- [x] CheckoutController đã có VNPay integration
- [x] Route `/checkout/vnpay-return` đã được đăng ký

### **Test:**
- [ ] Đăng nhập VNPay Merchant Admin thành công
- [ ] Cấu hình IPN URL trong admin panel
- [ ] Test thanh toán thành công với thẻ NCB
- [ ] Test hủy thanh toán
- [ ] Kiểm tra order được lưu đúng trong database
- [ ] Verify signature hoạt động đúng
- [ ] Test timeout scenario

### **Production Ready:**
- [ ] Đổi URL từ sandbox → production
- [ ] Nhận thông tin production từ VNPay
- [ ] Cập nhật IPN URL production
- [ ] Test kỹ trên staging environment
- [ ] Setup monitoring và alerting

---

**Ngày tích hợp:** 23/11/2025  
**Status:** ✅ SANDBOX - READY FOR TESTING  
**Next Step:** Test thanh toán với thẻ NCB và verify kết quả
