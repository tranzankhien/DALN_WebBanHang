# 🧪 TEST SOCIAL LOGIN - Quick Guide

## ✅ Pre-requisites

- [x] Server đang chạy: `http://localhost:8000`
- [x] Database migration đã chạy xong
- [x] .env có Google & Facebook credentials

## 🚀 Bước test

### 1. Kiểm tra Login Page

```bash
# Mở browser:
http://localhost:8000/login
```

**Expected**:
- ✅ Form login/password bình thường
- ✅ Divider "Hoặc đăng nhập bằng"
- ✅ Button "Continue with Google" (có logo Google 4 màu)
- ✅ Button "Continue with Facebook" (có logo Facebook xanh)

---

### 2. Test Google Login

**Steps**:
1. Click button "Continue with Google"
2. Browser redirect đến `accounts.google.com`
3. Chọn tài khoản Google của bạn
4. Cho phép quyền truy cập email, profile
5. Redirect về `http://localhost:8000/dashboard`

**Expected Result**:
- ✅ Login thành công
- ✅ Redirect về dashboard
- ✅ User được tạo trong database

**Verify Database**:
```bash
mysql -u root techshop -e "SELECT id, name, email, provider, role FROM users WHERE provider='google';"
```

**Expected Output**:
```
+----+-----------+------------------+----------+----------+
| id | name      | email            | provider | role     |
+----+-----------+------------------+----------+----------+
|  3 | Your Name | your@gmail.com   | google   | customer |
+----+-----------+------------------+----------+----------+
```

---

### 3. Test Facebook Login

**Steps**:
1. Logout (nếu đang login)
2. Trở về `/login`
3. Click button "Continue with Facebook"
4. Browser redirect đến `facebook.com`
5. Login Facebook (nếu chưa login)
6. Cho phép quyền truy cập
7. Redirect về dashboard

**Expected Result**:
- ✅ Login thành công với Facebook
- ✅ User được tạo với provider=facebook

**Verify**:
```bash
mysql -u root techshop -e "SELECT id, name, email, provider, role FROM users WHERE provider='facebook';"
```

---

### 4. Test Link Existing User

**Scenario**: Email đã tồn tại trong hệ thống

**Steps**:
1. Đăng ký user mới bằng email: `test@gmail.com` / password: `password`
2. Logout
3. Login bằng Google với cùng email `test@gmail.com`

**Expected Result**:
- ✅ Không tạo user mới
- ✅ Link provider vào user hiện có
- ✅ User có thể login bằng cả 2 cách: password hoặc Google

**Verify**:
```bash
mysql -u root techshop -e "SELECT id, name, email, provider, provider_id, role FROM users WHERE email='test@gmail.com';"
```

**Expected**:
```
+----+------+----------------+----------+--------------+----------+
| id | name | email          | provider | provider_id  | role     |
+----+------+----------------+----------+--------------+----------+
|  5 | Test | test@gmail.com | google   | 123456789... | customer |
+----+------+----------------+----------+--------------+----------+
```

---

### 5. Test Error Handling

**Test 1**: Invalid provider
```bash
# Truy cập:
http://localhost:8000/auth/twitter/redirect
```
**Expected**: 404 Not Found (chỉ accept google/facebook)

**Test 2**: Callback without authorization
```bash
# Truy cập trực tiếp:
http://localhost:8000/auth/google/callback
```
**Expected**: Redirect về `/login` với error message

---

### 6. Test Role Assignment

**Verify**: User đăng ký qua social login có role='customer'

```bash
mysql -u root techshop -e "SELECT email, role, provider FROM users WHERE provider IS NOT NULL;"
```

**Expected**: Tất cả có `role = 'customer'`

**Test admin access**:
```bash
# Login bằng social → Try access admin panel:
http://localhost:8000/admin/dashboard
```
**Expected**: 403 Forbidden (vì role=customer, không phải admin)

---

## ✅ Checklist hoàn chỉnh

- [ ] Login page hiển thị 2 buttons social
- [ ] Google login redirect đúng URL
- [ ] Google callback tạo user thành công
- [ ] Facebook login redirect đúng URL
- [ ] Facebook callback tạo user thành công
- [ ] Email verified tự động (email_verified_at có giá trị)
- [ ] Avatar được lưu (nếu có)
- [ ] Role mặc định là 'customer'
- [ ] Link với user hiện có nếu email trùng
- [ ] Error handling hoạt động (invalid provider, callback fail)
- [ ] Social user không thể access admin panel
- [ ] Logout và login lại nhiều lần OK

---

## 🐛 Nếu gặp lỗi

### Lỗi 1: "Client error: 401 Unauthorized"
**Nguyên nhân**: Credentials không đúng hoặc hết hạn

**Fix**:
- Kiểm tra `.env` có đúng GOOGLE_CLIENT_ID và SECRET không
- Verify callback URL trong Google Cloud Console

### Lỗi 2: "Redirect URI mismatch"
**Nguyên nhân**: Callback URL không khớp với config trong Google/Facebook

**Fix**:
```env
# Đảm bảo .env có:
GOOGLE_CALLBACK_URL=http://localhost:8000/auth/google/callback
FACEBOOK_CALLBACK_URL=http://localhost:8000/auth/facebook/callback

# Và URL này phải có trong:
# - Google Cloud Console > Credentials > Authorized redirect URIs
# - Facebook App > Settings > Valid OAuth Redirect URIs
```

### Lỗi 3: Button không hiển thị
**Check**:
```bash
# 1. Kiểm tra .env
cat .env | grep GOOGLE_CLIENT_ID

# 2. Clear cache
php artisan config:clear
php artisan view:clear

# 3. Restart server
php artisan serve
```

---

## 📊 Expected Data After Testing

```sql
-- Xem tất cả users
SELECT id, name, email, provider, role, email_verified_at 
FROM users 
ORDER BY id;

-- Count by provider
SELECT provider, COUNT(*) as total 
FROM users 
GROUP BY provider;

-- Users with avatar
SELECT name, email, avatar 
FROM users 
WHERE avatar IS NOT NULL;
```

---

**Ready to test?** Open: http://localhost:8000/login 🚀
