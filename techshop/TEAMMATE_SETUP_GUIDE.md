# 🚀 Quick Start - TechShop Project

## Cho Đồng Nghiệp Clone Project Lần Đầu

### 1. Clone & Install

```bash
# Clone repository
git clone <repository-url>
cd techshop

# Install dependencies
composer install
npm install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate
```

### 2. Cấu Hình Database

**QUAN TRỌNG**: Sửa đường dẫn file `ca.pem` trong `.env`:

```env
MYSQL_ATTR_SSL_CA="/path/to/your/techshop/ca.pem"
```

Thay `/path/to/your/techshop/` bằng đường dẫn thực tế trên máy bạn.

**Ví dụ:**
- Windows: `"C:/Users/YourName/projects/techshop/ca.pem"`
- Linux/Mac: `"/home/username/projects/techshop/ca.pem"`

### 3. Test Kết Nối

```bash
# Kiểm tra database connection
php artisan db:show

# Xem tables đã có sẵn (không cần migrate)
php artisan migrate:status
```

### 4. Chạy Server

```bash
# Build assets
npm run build

# Start development server
php artisan serve
```

Mở trình duyệt: http://localhost:8000

### 5. Login Admin

```
Email: admin@techshop.com
Password: admin123
```

---

## 📚 Hướng Dẫn Chi Tiết

Xem file **`AIVEN_DATABASE_SETUP.md`** để biết:
- Cách xem database bằng MySQL Workbench/DBeaver
- Workflow phát triển với team
- Troubleshooting
- Best practices

---

## ⚡ Commands Thường Dùng

```bash
# Xem database info
php artisan db:show

# Check migrations
php artisan migrate:status

# Create new migration
php artisan make:migration create_something_table

# Run migrations (careful!)
php artisan migrate

# Create model with migration
php artisan make:model ModelName -m

# Laravel Tinker (test code)
php artisan tinker

# Clear cache
php artisan cache:clear
php artisan config:clear
```

---

## 🔍 Xem Database Trực Quan

### Option 1: MySQL Workbench (Recommended)

1. Install: https://dev.mysql.com/downloads/workbench/
2. New Connection với thông tin:
   ```
   Host: mysql-1536965f-st-f0b3.i.aivencloud.com
   Port: 16208
   User: avnadmin
   Password: [Xem trong file .env hoặc hỏi team lead]
   Database: defaultdb
   SSL CA: ca.pem (trong thư mục project)
   ```

### Option 2: DBeaver (Free)

1. Install: https://dbeaver.io/download/
2. New MySQL Connection với thông tin tương tự
3. Enable SSL với CA certificate = `ca.pem`

### Option 3: Command Line

```bash
php artisan tinker
>>> DB::table('users')->count();
>>> DB::table('products')->get();
```

---

## ⚠️ Lưu Ý

1. **Database là SHARED** - tất cả dev dùng chung
2. **KHÔNG chạy** `php artisan migrate:fresh` trừ khi đã thỏa thuận
3. **Test migrations** cẩn thận trước khi chạy
4. **Backup** trước khi làm thay đổi lớn
5. **Thông báo team** trước khi migrate

---

## 🆘 Gặp Lỗi?

### "Connection refused" hoặc "SSL error"

```bash
# Kiểm tra đường dẫn ca.pem trong .env
# Đảm bảo có dấu ngoặc kép nếu path có khoảng trắng
MYSQL_ATTR_SSL_CA="/path with spaces/ca.pem"
```

### "Access denied"

- Verify username/password trong `.env`
- File `ca.pem` phải tồn tại trong project

### "Table not found"

```bash
# Check migrations status
php artisan migrate:status

# Nếu cần, chạy migrations
php artisan migrate
```

---

## 📞 Cần Giúp?

- Xem: `AIVEN_DATABASE_SETUP.md`
- Hỏi team trên Slack/Discord
- Check Laravel Docs: https://laravel.com/docs

---

**Happy Coding! 🎉**
