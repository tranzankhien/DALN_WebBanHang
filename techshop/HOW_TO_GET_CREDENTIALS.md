# 📌 HƯỚNG DẪN LẤY CREDENTIALS

## ⚠️ Quan Trọng - Đọc Trước Khi Setup!

File documentation không chứa password thật vì lý do bảo mật. Bạn cần lấy credentials từ các nguồn sau:

## 🔐 Cách Lấy Database Password

### Option 1: Từ Team Lead (Khuyên Dùng)

Liên hệ team lead để nhận:
- Aiven database password
- File `ca.pem` (SSL certificate)
- File `CREDENTIALS_PRIVATE.md` (chứa tất cả thông tin)

**Nhận qua:**
- Encrypted chat (Signal, WhatsApp, Telegram)
- Password manager share (1Password, Bitwarden)
- Secure note trong team tools (Notion, Confluence)

### Option 2: Từ File .env Của Đồng Nghiệp

Nếu đồng nghiệp đã setup, xin họ share file `.env` qua kênh bảo mật.

**⚠️ KHÔNG bao giờ:**
- Share qua email thường
- Post public trên chat
- Commit vào Git

## 📋 Thông Tin Bạn Cần

Sau khi có password, cập nhật vào file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=mysql-1536965f-st-f0b3.i.aivencloud.com
DB_PORT=16208
DB_DATABASE=defaultdb
DB_USERNAME=avnadmin
DB_PASSWORD=[PASTE_PASSWORD_HERE]
MYSQL_ATTR_SSL_CA="/full/path/to/your/techshop/ca.pem"
```

## 📁 Files Cần Có

1. **`.env`** - File cấu hình (copy từ `.env.example` và điền password)
2. **`ca.pem`** - SSL certificate (lấy từ team lead hoặc Aiven console)

## 🔄 Quick Setup Flow

```bash
# 1. Clone project
git clone <repo-url>
cd techshop

# 2. Copy .env.example
cp .env.example .env

# 3. Install dependencies
composer install
npm install

# 4. Generate key
php artisan key:generate

# 5. Liên hệ team lead để lấy:
#    - Database password
#    - File ca.pem

# 6. Cập nhật .env với password và đường dẫn ca.pem

# 7. Test connection
php artisan db:show

# 8. Build & Run
npm run build
php artisan serve
```

## 🌐 Truy Cập Aiven Console

Nếu cần truy cập Aiven console trực tiếp:

1. URL: https://console.aiven.io/
2. Hỏi team lead về account credentials
3. Service name: MySQL-1536965f-st-f0b3

## 📖 Documentation

Xem các file sau để biết thêm chi tiết:

- `TEAMMATE_SETUP_GUIDE.md` - Quick start guide
- `AIVEN_DATABASE_SETUP.md` - Full documentation
- `SETUP_COMPLETE_AIVEN.md` - Complete overview

## 💡 Tips

- **Đổi password admin** sau khi login lần đầu
- **Backup .env file** của bạn ở nơi an toàn
- **Không share** credentials qua kênh không bảo mật
- **Update team** nếu phát hiện vấn đề bảo mật

---

**Cần giúp đỡ?** Liên hệ team lead hoặc hỏi trong group chat!
