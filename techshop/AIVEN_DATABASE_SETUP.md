# 🌐 Hướng Dẫn Setup Database Aiven Cloud

## 📋 Tổng Quan

Dự án này sử dụng **Aiven MySQL Cloud Database** để cho phép nhiều developers cùng phát triển trên một database chung, thay vì mỗi người dùng database local riêng.

## ✅ Lợi Ích

- ✨ **Collaboration**: Tất cả developers làm việc trên cùng một database
- 🔄 **Real-time Sync**: Thay đổi của người này được thấy ngay bởi người khác
- 🌍 **Remote Access**: Truy cập từ bất kỳ đâu, không cần VPN
- 🔒 **Secure**: SSL/TLS encryption cho tất cả kết nối
- 💾 **Backup**: Automatic backups by Aiven

---

## 🚀 Setup Cho Đồng Nghiệp (Clone Project)

### Bước 1: Clone Repository

```bash
git clone <repository-url>
cd techshop
```

### Bước 2: Cài Đặt Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### Bước 3: Copy File Environment

```bash
cp .env.example .env
```

### Bước 4: Generate Application Key

```bash
php artisan key:generate
```

### Bước 5: Cấu Hình Database Connection

**QUAN TRỌNG**: File `.env` đã có sẵn thông tin kết nối Aiven. Bạn chỉ cần đảm bảo các thông tin sau đúng:

```env
DB_CONNECTION=mysql
DB_HOST=mysql-1536965f-st-f0b3.i.aivencloud.com
DB_PORT=16208
DB_DATABASE=defaultdb
DB_USERNAME=avnadmin
DB_PASSWORD=[YOUR_AIVEN_PASSWORD]
MYSQL_ATTR_SSL_CA="/home/YOUR_USERNAME/path/to/techshop/ca.pem"
```

**⚠️ LƯU Ý**: 
- Đường dẫn `MYSQL_ATTR_SSL_CA` phải được đặt trong dấu ngoặc kép `"` nếu có khoảng trắng
- Cập nhật đường dẫn phù hợp với máy của bạn

### Bước 6: Download CA Certificate

File `ca.pem` đã có sẵn trong repository. Nếu bị thiếu, tải lại:

```bash
# Tự động tải (nếu script có sẵn)
./download-aiven-ca.sh

# Hoặc tải thủ công từ Aiven Console:
# 1. Đăng nhập vào https://console.aiven.io/
# 2. Vào service MySQL của bạn
# 3. Tab "Overview" → Click "Show" ở mục "CA certificate"
# 4. Copy nội dung và save vào file ca.pem
```

### Bước 7: Test Kết Nối

```bash
# Kiểm tra thông tin database
php artisan db:show

# Xem trạng thái migrations (không cần migrate vì database đã có tables)
php artisan migrate:status
```

### Bước 8: Chạy Development Server

```bash
# Build assets
npm run build

# Start server
php artisan serve
```

Truy cập: http://localhost:8000

---

## 🔧 Chi Tiết Kỹ Thuật

### Thông Tin Kết Nối

| Parameter | Value |
|-----------|-------|
| **Host** | `mysql-1536965f-st-f0b3.i.aivencloud.com` |
| **Port** | `16208` |
| **Database** | `defaultdb` |
| **Username** | `avnadmin` |
| **Password** | `[YOUR_AIVEN_PASSWORD]` |
| **SSL Mode** | `REQUIRED` |
| **CA Certificate** | `ca.pem` (included in repo) |

### Cấu Hình Laravel

File `config/database.php` đã được cấu hình để hỗ trợ SSL:

```php
'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'laravel'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => env('MYSQL_ATTR_SSL_VERIFY_SERVER_CERT', false),
    ]) : [],
],
```

---

## 🔍 Xem Database Trực Quan

### Option 1: MySQL Workbench (Khuyên Dùng)

#### Cài Đặt:

```bash
# Ubuntu/Debian
sudo apt install mysql-workbench

# Windows: Download từ https://dev.mysql.com/downloads/workbench/
# macOS: brew install --cask mysqlworkbench
```

#### Kết Nối:

1. Mở MySQL Workbench
2. Click **"+"** để tạo connection mới
3. Điền thông tin:

```
Connection Name: TechShop Aiven
Hostname: mysql-1536965f-st-f0b3.i.aivencloud.com
Port: 16208
Username: avnadmin
Password: [YOUR_AIVEN_PASSWORD]
Default Schema: defaultdb
```

4. Tab **SSL**:
   - SSL Mode: **Require**
   - SSL CA File: Browse đến file `ca.pem`

5. Click **Test Connection** → **OK**

#### Screenshot:
![MySQL Workbench Connection](https://docs.aiven.io/images/mysql-workbench.png)

---

### Option 2: DBeaver (Free & Cross-platform)

#### Cài Đặt:

```bash
# Ubuntu/Debian
sudo snap install dbeaver-ce

# Windows/macOS: Download từ https://dbeaver.io/download/
```

#### Kết Nối:

1. Mở DBeaver
2. **Database** → **New Database Connection**
3. Chọn **MySQL**
4. Điền thông tin:

```
Host: mysql-1536965f-st-f0b3.i.aivencloud.com
Port: 16208
Database: defaultdb
Username: avnadmin
Password: [YOUR_AIVEN_PASSWORD]
```

5. Tab **SSL**:
   - Check **Use SSL**
   - SSL Mode: **REQUIRED**
   - CA Certificate: Browse đến `ca.pem`

6. **Test Connection** → **Finish**

---

### Option 3: Command Line (Quick Check)

```bash
# Kết nối qua mysql client
mysql --host=mysql-1536965f-st-f0b3.i.aivencloud.com \
      --port=16208 \
      --user=avnadmin \
      --password=[YOUR_AIVEN_PASSWORD] \
      --database=defaultdb \
      --ssl-mode=REQUIRED \
      --ssl-ca=ca.pem

# Hoặc dùng Laravel Tinker
php artisan tinker
>>> DB::table('users')->count();
>>> DB::table('products')->get();
```

---

### Option 4: Aiven Web Console

1. Đăng nhập: https://console.aiven.io/
2. Chọn service **MySQL**
3. Tab **Databases**
4. Click **Open in Aiven Web Console**

**Lưu ý**: Web console có giới hạn tính năng, khuyên dùng MySQL Workbench hoặc DBeaver.

---

## 📊 Cấu Trúc Database

### Tables (17 tables)

```sql
- users                           # User accounts (admin, customers)
- cache, cache_locks              # Cache system
- jobs, job_batches, failed_jobs  # Queue system
- sessions                        # Session storage
- password_reset_tokens           # Password resets
- categories                      # Product categories
- products                        # Products
- product_images                  # Product images
- product_attributes              # Attributes (color, size, etc.)
- product_attribute_values        # Attribute values
- inventory_items                 # Stock management
- inventory_transactions          # Stock history
- carts                          # Shopping carts
- cart_items                     # Cart items
- orders                         # Orders
- order_items                    # Order items
- payments                       # Payments
- user_addresses                 # Shipping addresses
```

### Default Admin Account

```
Email: admin@techshop.com
Password: admin123
```

---

## 🔐 Security Best Practices

### ⚠️ QUAN TRỌNG

1. **KHÔNG commit file `.env`** vào Git
2. **KHÔNG share credentials** công khai
3. **Đổi password** admin sau khi setup
4. **Rotate database password** định kỳ từ Aiven console

### File `.gitignore` đã bao gồm:

```gitignore
.env
ca.pem
*.pem
```

### Cho Production:

1. Tạo separate database service cho production
2. Sử dụng environment variables khác nhau
3. Enable IP whitelist trên Aiven
4. Enable automatic backups

---

## 🤝 Workflow Phát Triển

### Khi Làm Việc Với Database:

#### 1. Migrations (Thay đổi cấu trúc)

```bash
# Tạo migration mới
php artisan make:migration create_new_table

# Chạy migrations (tất cả dev sẽ thấy thay đổi)
php artisan migrate

# Rollback nếu cần
php artisan migrate:rollback
```

#### 2. Seeders (Thêm dữ liệu mẫu)

```bash
# Tạo seeder
php artisan make:seeder ProductSeeder

# Chạy seeder
php artisan db:seed --class=ProductSeeder
```

#### 3. Models (Phát triển tính năng)

```bash
# Tạo model với migration
php artisan make:model Product -m

# Tạo model với controller và migration
php artisan make:model Product -mcr
```

### Best Practices:

✅ **DO:**
- Tạo migrations cho mọi thay đổi database
- Test migrations trên local trước
- Commit migrations vào Git
- Thông báo team trước khi chạy migrations
- Backup trước khi chạy migrations phức tạp

❌ **DON'T:**
- Không edit trực tiếp trên database
- Không xóa dữ liệu của người khác
- Không chạy `migrate:fresh` trên shared database (trừ khi thỏa thuận)

---

## 🆘 Troubleshooting

### Lỗi: "SQLSTATE[HY000] [2002] Connection refused"

**Giải pháp:**
- Kiểm tra internet connection
- Verify thông tin trong `.env`
- Kiểm tra file `ca.pem` tồn tại

### Lỗi: "SSL connection error"

**Giải pháp:**
```bash
# Tải lại CA certificate
rm ca.pem
./download-aiven-ca.sh

# Hoặc download từ Aiven console
```

### Lỗi: "Access denied for user"

**Giải pháp:**
- Verify username/password trong `.env`
- Password có thể đã được rotate từ Aiven console

### Lỗi: "The environment file is invalid"

**Giải pháp:**
```bash
# Đường dẫn có khoảng trắng cần dấu ngoặc kép
MYSQL_ATTR_SSL_CA="/path/with spaces/ca.pem"

# Không được:
MYSQL_ATTR_SSL_CA=/path/with spaces/ca.pem
```

### Database quá chậm?

**Giải pháp:**
- Aiven free tier có giới hạn performance
- Consider upgrade plan từ Aiven console
- Optimize queries và add indexes

---

## 📝 Commands Hữu Ích

```bash
# Kiểm tra connection
php artisan db:show

# Xem migrations status
php artisan migrate:status

# Fresh start (⚠️ XÓA TẤT CẢ DỮ LIỆU)
php artisan migrate:fresh --seed

# Backup database
php artisan db:backup  # (cần package)

# Laravel Tinker (interactive shell)
php artisan tinker

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

---

## 📞 Support

### Vấn đề về Database/Aiven:
- Aiven Console: https://console.aiven.io/
- Aiven Docs: https://docs.aiven.io/
- Support: support@aiven.io

### Vấn đề về Laravel:
- Laravel Docs: https://laravel.com/docs
- Laracasts: https://laracasts.com/

### Liên hệ Team:
- [Your contact info here]

---

## 🎯 Next Steps

1. **Setup CI/CD**: Auto migrations khi deploy
2. **Monitoring**: Setup alerts cho database
3. **Backup Strategy**: Schedule regular backups
4. **Read Replicas**: Scale read operations
5. **Connection Pooling**: Optimize connections

---

## 📚 Additional Resources

- [Aiven MySQL Documentation](https://docs.aiven.io/docs/products/mysql)
- [Laravel Database Documentation](https://laravel.com/docs/database)
- [MySQL Workbench Manual](https://dev.mysql.com/doc/workbench/en/)
- [DBeaver Documentation](https://dbeaver.com/docs/)

---

**Last Updated**: October 23, 2025
**Version**: 1.0
**Maintainer**: [Your Name]
