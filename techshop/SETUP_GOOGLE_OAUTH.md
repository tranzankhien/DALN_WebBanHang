# 🔧 Cách tạo Google OAuth mới cho TechShop

## ⚠️ Vấn đề hiện tại

Credentials hiện tại trong `.env` là của **KT Shop** (dự án của thành viên khác):
```env
GOOGLE_CLIENT_ID=1095730069115-u2qrvdhu88aofmrk1k01is2fkufr4nf1.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=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
```

👉 Credentials này chỉ hoạt động cho **KT Shop**, không phải **TechShop**!

---

## ✅ GIẢI PHÁP: Tạo credentials mới

### Bước 1: Truy cập Google Cloud Console

**URL**: https://console.cloud.google.com/

1. Đăng nhập bằng tài khoản Google của bạn
2. Click **Select a project** → **New Project**
3. Nhập tên: `TechShop` 
4. Click **Create**

---

### Bước 2: Enable Google+ API

1. Vào menu ☰ → **APIs & Services** → **Library**
2. Tìm: `Google+ API`
3. Click **Enable**

---

### Bước 3: Tạo OAuth Consent Screen

1. Vào menu ☰ → **APIs & Services** → **OAuth consent screen**
2. Chọn **External** → Click **Create**

**Điền thông tin**:
```
App name: TechShop
User support email: [email của bạn]
Developer contact email: [email của bạn]
```

3. Click **Save and Continue**
4. **Scopes**: Click **Add or Remove Scopes**
   - Chọn: `email`
   - Chọn: `profile`
   - Chọn: `openid`
5. Click **Save and Continue**
6. **Test users**: Thêm email của bạn để test
7. Click **Save and Continue**

---

### Bước 4: Tạo OAuth Client ID

1. Vào menu ☰ → **APIs & Services** → **Credentials**
2. Click **+ Create Credentials** → **OAuth client ID**
3. Application type: **Web application**
4. Name: `TechShop Web Client`

**Authorized JavaScript origins**:
```
http://localhost:8000
http://127.0.0.1:8000
```

**Authorized redirect URIs**:
```
http://localhost:8000/auth/google/callback
http://127.0.0.1:8000/auth/google/callback
```

5. Click **Create**

---

### Bước 5: Copy Credentials

Sau khi tạo xong, Google sẽ hiển thị popup với:
- **Client ID**: `123456789-abcdefghijk.apps.googleusercontent.com`
- **Client Secret**: `GOCSPX-xyz123abc...`

📋 **Copy cả 2 giá trị này!**

---

### Bước 6: Cập nhật .env của TechShop

```bash
cd "/home/twan/web advance/empty/techshop"
nano .env
```

**Thay thế**:
```env
# OLD (KT Shop - KHÔNG DÙNG)
# GOOGLE_CLIENT_ID=1095730069115-u2qrvdhu88aofmrk1k01is2fkufr4nf1.apps.googleusercontent.com
# GOOGLE_CLIENT_SECRET=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

# NEW (TechShop - CỦA BẠN)
GOOGLE_CLIENT_ID=[Paste Client ID mới ở đây]
GOOGLE_CLIENT_SECRET=[Paste Client Secret mới ở đây]
GOOGLE_CALLBACK_URL=http://localhost:8000/auth/google/callback
```

**Lưu file**: `Ctrl + O` → `Enter` → `Ctrl + X`

---

### Bước 7: Clear Cache và Test

```bash
# Clear config cache
php artisan config:clear
php artisan cache:clear

# Restart server
php artisan serve
```

**Test lại**:
1. Truy cập: http://localhost:8000/login
2. Click "Continue with Google"
3. ✅ Lần này sẽ hiển thị màn hình consent của **TechShop**, không phải KT Shop!

---

## 🔄 TƯƠNG TỰ CHO FACEBOOK

### Bước 1: Tạo Facebook App

**URL**: https://developers.facebook.com/apps/

1. Click **Create App**
2. Use case: **Authenticate and request data from users**
3. App Type: **Business**
4. App name: `TechShop`
5. App contact email: [email của bạn]
6. Click **Create App**

---

### Bước 2: Setup Facebook Login

1. Vào **Dashboard** → **Add Product** → Chọn **Facebook Login** → **Set Up**
2. Platform: **Web**
3. Site URL: `http://localhost:8000`
4. Click **Save**

---

### Bước 3: Configure OAuth Redirect URIs

1. Vào sidebar → **Facebook Login** → **Settings**
2. **Valid OAuth Redirect URIs**:
```
http://localhost:8000/auth/facebook/callback
http://127.0.0.1:8000/auth/facebook/callback
```
3. Click **Save Changes**

---

### Bước 4: Copy App ID & Secret

1. Vào sidebar → **Settings** → **Basic**
2. Copy **App ID**
3. Click **Show** bên cạnh **App Secret** → Copy

---

### Bước 5: Update .env

```env
# OLD (KT Shop - KHÔNG DÙNG)
# FACEBOOK_CLIENT_ID=777480994997477
# FACEBOOK_CLIENT_SECRET=191e4c44bd254d578ff898a7c118bc72

# NEW (TechShop - CỦA BẠN)
FACEBOOK_CLIENT_ID=[Paste App ID mới]
FACEBOOK_CLIENT_SECRET=[Paste App Secret mới]
FACEBOOK_CALLBACK_URL=http://localhost:8000/auth/facebook/callback
```

---

### Bước 6: Set App to Live Mode

⚠️ **Quan trọng**: Facebook App mặc định ở Development mode

1. Vào **Settings** → **Basic**
2. Kéo xuống **App Mode**
3. Toggle từ **Development** → **Live**

---

## ✅ CHECKLIST HOÀN THÀNH

### Google OAuth:
- [ ] Tạo Google Cloud Project mới: "TechShop"
- [ ] Enable Google+ API
- [ ] Setup OAuth Consent Screen
- [ ] Tạo OAuth Client ID (Web application)
- [ ] Add Authorized redirect URIs: `http://localhost:8000/auth/google/callback`
- [ ] Copy Client ID & Secret mới
- [ ] Update `.env` với credentials mới
- [ ] Clear cache: `php artisan config:clear`
- [ ] Test login: Hiển thị "TechShop" thay vì "KT Shop"

### Facebook Login:
- [ ] Tạo Facebook App mới: "TechShop"
- [ ] Add Facebook Login product
- [ ] Configure Valid OAuth Redirect URIs
- [ ] Copy App ID & App Secret
- [ ] Update `.env` với credentials mới
- [ ] Set App to Live mode
- [ ] Test login

---

## 🐛 TROUBLESHOOTING

### Lỗi 1: "redirect_uri_mismatch"
**Nguyên nhân**: Redirect URI không khớp

**Fix**:
- Kiểm tra `.env`: `GOOGLE_CALLBACK_URL=http://localhost:8000/auth/google/callback`
- Kiểm tra Google Console: Authorized redirect URIs phải có URL này
- Chú ý: `http://` vs `https://`, `localhost` vs `127.0.0.1`

### Lỗi 2: "This app isn't verified"
**Nguyên nhân**: App chưa được Google verify

**Fix**: 
- Click "Advanced" → "Go to TechShop (unsafe)"
- Hoặc: Add email test user trong OAuth Consent Screen

### Lỗi 3: Facebook "App Not Setup"
**Nguyên nhân**: App còn ở Development mode

**Fix**: 
- Settings → Basic → App Mode → Toggle to **Live**

---

## 📝 LƯU Ý QUAN TRỌNG

### 1. ⚠️ KHÔNG DÙNG Credentials của người khác!
```
❌ KT Shop credentials = Dự án của thành viên khác
✅ TechShop credentials = Dự án của BẠN
```

### 2. ⚠️ Production vs Development
- Hiện tại: `http://localhost:8000` (development)
- Production: Phải update lại với domain thật (VD: `https://techshop.com`)

### 3. ⚠️ Security
- **KHÔNG commit** `.env` lên Git
- **KHÔNG share** Client Secret với ai
- Sử dụng `.env.example` để chia sẻ template

---

## 🎯 KẾT QUẢ MONG ĐỢI

**Trước** (dùng credentials KT Shop):
```
Click "Continue with Google"
→ Hiển thị: "Đăng nhập bằng Google vào KT Shop"
→ Error: redirect_uri_mismatch ❌
```

**Sau** (dùng credentials TechShop mới):
```
Click "Continue with Google"
→ Hiển thị: "Đăng nhập bằng Google vào TechShop" ✅
→ Consent screen: "TechShop wants to access..."
→ Login thành công → Redirect về /dashboard ✅
```

---

## 📚 Tài liệu tham khảo

- Google Cloud Console: https://console.cloud.google.com/
- Facebook Developers: https://developers.facebook.com/
- Laravel Socialite: https://laravel.com/docs/11.x/socialite

---

**Sau khi setup xong, credentials mới sẽ CHỈ hoạt động cho TechShop của bạn!** 🎉
