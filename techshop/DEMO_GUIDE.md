# 🚀 Hướng Dẫn Sử Dụng TechShop

## ✅ Hoàn Thành Setup

Dự án TechShop đã được setup thành công và đang chạy!

## 🌐 Truy Cập Ứng Dụng

### Website TechShop
- **URL**: http://localhost:8000 hoặc http://127.0.0.1:8000
- Ứng dụng đã được mở trong Simple Browser của VS Code

### phpMyAdmin (Truy cập Root không cần mật khẩu)
- **URL**: http://localhost/phpmyadmin
- **Tự động đăng nhập**: Root user, không cần nhập mật khẩu
- **Database**: techshop

## 👤 Tài Khoản Demo

### Admin Account (từ seeder)
- Kiểm tra trong database table `users` để xem tài khoản admin đã được tạo

## 🗄️ Database

### Thông tin kết nối
- **Host**: 127.0.0.1
- **Port**: 3306
- **Database**: techshop
- **Username**: laravel
- **Password**: 123456

### Cấu trúc Database
Database đã được tạo với các bảng:
- users (người dùng, admin)
- categories (danh mục sản phẩm)
- products (sản phẩm)
- product_images (hình ảnh sản phẩm)
- product_attributes (thuộc tính: màu sắc, kích thước, v.v.)
- product_attribute_values (giá trị thuộc tính)
- inventory_items (tồn kho)
- inventory_transactions (lịch sử nhập/xuất kho)
- carts (giỏ hàng)
- cart_items (sản phẩm trong giỏ hàng)
- orders (đơn hàng)
- order_items (chi tiết đơn hàng)
- payments (thanh toán)
- user_addresses (địa chỉ giao hàng)

## 🛠️ Lệnh Hữu Ích

### Khởi động Development Server
```bash
cd "/home/twan/web advance/empty/DALN_WebBanHang/techshop"
php artisan serve
```

Server sẽ chạy tại: http://127.0.0.1:8000

### Chạy Vite (Hot Reload cho CSS/JS)
```bash
npm run dev
```

### Build Assets cho Production
```bash
npm run build
```

### Reset Database (Xóa tất cả và chạy lại)
```bash
php artisan migrate:fresh --seed
```

### Chạy cả Server + Vite + Queue + Logs
```bash
npm run dev:full
# hoặc
composer dev
```

## 📝 Scripts Đã Tạo

### setup-database.sh
Tạo database và user MySQL/MariaDB:
```bash
./setup-database.sh
```

### setup-phpmyadmin.sh
Cấu hình phpMyAdmin để root truy cập không cần mật khẩu:
```bash
./setup-phpmyadmin.sh
```

## 🔍 Kiểm Tra Database

### Qua Terminal
```bash
# Truy cập MySQL/MariaDB với quyền root
sudo mysql -u root

# Hoặc dùng user laravel
mysql -u laravel -p123456 techshop
```

### Qua phpMyAdmin
1. Mở trình duyệt: http://localhost/phpmyadmin
2. Tự động đăng nhập (không cần mật khẩu)
3. Chọn database `techshop` từ sidebar trái
4. Xem các bảng và dữ liệu

## 🚨 Troubleshooting

### Server không chạy
```bash
# Kiểm tra port 8000 có bị chiếm không
lsof -i :8000

# Chạy trên port khác
php artisan serve --port=8080
```

### Lỗi Database
```bash
# Chạy lại setup database
./setup-database.sh

# Kiểm tra kết nối
php artisan tinker
>>> DB::connection()->getPdo();
```

### Lỗi Assets
```bash
# Xóa cache và build lại
rm -rf public/build
npm run build
```

## 📦 Composer Scripts

```bash
# Chạy tất cả (server + queue + logs + vite)
composer dev

# Setup lần đầu
composer setup

# Chạy tests
composer test
```

## 🎯 Các Tính Năng Chính

1. ✅ Quản lý sản phẩm với thuộc tính đa dạng
2. ✅ Hệ thống giỏ hàng
3. ✅ Quản lý đơn hàng
4. ✅ Quản lý tồn kho
5. ✅ Phân quyền người dùng
6. ✅ Thanh toán
7. ✅ Địa chỉ giao hàng
8. ✅ Social login (Google OAuth)

## 📚 Tài Liệu Thêm

- `QUICK_START.md` - Hướng dẫn bắt đầu nhanh
- `DATABASE_STRUCTURE.md` - Chi tiết cấu trúc database
- `TESTING_GUIDE.md` - Hướng dẫn testing
- `SETUP_GOOGLE_OAUTH.md` - Cấu hình Google login

---

**Chúc bạn code vui vẻ! 🎉**
