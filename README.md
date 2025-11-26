# TechShop - E-commerce Platform 🛒

Website bán các đồ điện tử như: màn hình, sạc, tai nghe, điện thoại,...

## 🎉 Status: READY FOR TESTING!

✅ **Admin Panel**: Hoàn thành 3 modules chính  
✅ **Social Login**: Tích hợp Google & Facebook  
✅ **Database**: 22 tables với đầy đủ relationships  
✅ **Authentication**: Laravel Breeze + Social OAuth  

---

## 🚀 Công nghệ sử dụng

- **Framework**: Laravel 12.x
- **PHP**: 8.2+
- **Database**: MySQL
- **Frontend**: Tailwind CSS + Vite
- **Authentication**: Laravel Breeze + Socialite
- **Social Login**: Google OAuth 2.0, Facebook Login

---

## 📦 Cài đặt

### 1. Clone project

```bash
cd "/home/twan/web advance/empty/techshop"
```

### 2. Cài đặt dependencies

```bash
composer install
npm install
```

### 3. Cấu hình môi trường

File `.env` đã được cấu hình sẵn:

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=techshop
DB_USERNAME=root
DB_PASSWORD=

# Social Login (Đã tích hợp từ folder Source)
GOOGLE_CLIENT_ID=1095730069115-u2qrvdhu88aofmrk1k01is2fkufr4nf1.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=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
GOOGLE_CALLBACK_URL=http://localhost:8000/auth/google/callback

FACEBOOK_CLIENT_ID=777480994997477
FACEBOOK_CLIENT_SECRET=191e4c44bd254d578ff898a7c118bc72
FACEBOOK_CALLBACK_URL=http://localhost:8000/auth/facebook/callback
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=techshop
DB_USERNAME=root
DB_PASSWORD=
```

chạy lệnh sau để áp dụng cấu hình 
```bash
cp .env.example .env
```

### 4. Tạo database

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS techshop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 5. Chạy migrations

```bash
php artisan migrate
```

### 6. Seed dữ liệu mẫu

```bash
php artisan db:seed
```

### 7. Chạy server

```bash
php artisan serve
```

## 👤 Tài khoản mặc định

**Admin Account:**
- Email: `admin@techshop.com`
- Password: `password`

**Customer Account:**
- Email: `customer@techshop.com`
- Password: `password`

## 📊 Cấu trúc Database

### Các bảng chính:

#### 1. **users** - Quản lý người dùng
- `id`: Primary key
- `name`: Tên người dùng
- `email`: Email (unique)
- `password`: Mật khẩu (hashed)
- `role`: Vai trò (customer/admin)

#### 2. **categories** - Danh mục sản phẩm
- `id`: Primary key
- `parent_id`: ID danh mục cha (hỗ trợ danh mục con)
- `slug`: URL friendly
- `name`: Tên danh mục
- `description`: Mô tả
- `image_url`: Ảnh đại diện
- `status`: Trạng thái (active/inactive)
- `display_order`: Thứ tự hiển thị

#### 3. **inventory_items** - Quản lý kho (SKU)
- `id`: Primary key
- `sku`: Mã SKU duy nhất
- `name`: Tên sản phẩm trong kho
- `description`: Mô tả
- `brand`: Thương hiệu
- `category_id`: Danh mục
- `cost_price`: Giá nhập
- `stock_quantity`: Tổng số lượng trong kho

#### 4. **products** - Sản phẩm bán (Listing)
- `id`: Primary key
- `inventory_item_id`: Liên kết với kho
- `name`: Tên marketing
- `description`: Mô tả
- `price`: Giá bán
- `discount_price`: Giá khuyến mãi
- `stock`: Số lượng hiển thị
- `max_stock`: Số lượng tối đa muốn bán
- `status`: Trạng thái (draft/active/inactive/out_of_stock)
- `is_featured`: Sản phẩm nổi bật
- `display_order`: Thứ tự hiển thị
- `published_at`: Thời điểm công khai

#### 5. **product_images** - Hình ảnh sản phẩm
- `id`: Primary key
- `product_id`: ID sản phẩm
- `image_url`: Đường dẫn ảnh
- `is_main`: Ảnh chính
- `display_order`: Thứ tự hiển thị

#### 6. **product_attributes** - Thuộc tính sản phẩm
- `id`: Primary key
- `category_id`: Danh mục
- `name`: Tên thuộc tính (RAM, ROM, Chip,...)
- `unit`: Đơn vị (GB, inch, Hz,...)

#### 7. **product_attribute_values** - Giá trị thuộc tính
- `id`: Primary key
- `inventory_item_id`: ID sản phẩm trong kho
- `attribute_id`: ID thuộc tính
- `value`: Giá trị (8GB, 128GB,...)

#### 8. **orders** - Đơn hàng
- `id`: Primary key
- `user_id`: ID người dùng
- `total_amount`: Tổng tiền
- `status`: Trạng thái (pending/confirmed/shipped/completed/cancelled)
- `shipping_name`: Tên người nhận
- `shipping_phone`: SĐT người nhận
- `shipping_address`: Địa chỉ giao hàng

#### 9. **order_items** - Chi tiết đơn hàng
- `id`: Primary key
- `order_id`: ID đơn hàng
- `product_id`: ID sản phẩm
- `inventory_item_id`: ID SKU thực tế
- `quantity`: Số lượng
- `price`: Giá tại thời điểm đặt

#### 10. **payments** - Thanh toán
- `id`: Primary key
- `order_id`: ID đơn hàng (unique)
- `method`: Phương thức (cod/credit_card/paypal/bank_transfer)
- `amount`: Số tiền
- `status`: Trạng thái (pending/paid/failed)
- `transaction_id`: Mã giao dịch
- `paid_at`: Thời gian thanh toán

#### 11. **carts** - Giỏ hàng
- `id`: Primary key
- `user_id`: ID người dùng (unique)

#### 12. **cart_items** - Sản phẩm trong giỏ
- `id`: Primary key
- `cart_id`: ID giỏ hàng
- `product_id`: ID sản phẩm
- `quantity`: Số lượng

#### 13. **inventory_transactions** - Lịch sử giao dịch kho
- `id`: Primary key
- `inventory_item_id`: ID sản phẩm trong kho
- `type`: Loại (import/export/adjustment/return)
- `quantity`: Số lượng thay đổi
- `reference_type`: Loại tham chiếu
- `reference_id`: ID tham chiếu
- `note`: Ghi chú
- `created_by`: Người tạo

#### 14. **user_addresses** - Địa chỉ người dùng
- `id`: Primary key
- `user_id`: ID người dùng
- `full_name`: Tên đầy đủ
- `phone`: Số điện thoại
- `address`: Địa chỉ
- `city`: Thành phố
- `district`: Quận/huyện
- `ward`: Phường/xã
- `is_default`: Địa chỉ mặc định

## 🎯 Tính năng dự kiến

### Giao diện Admin

1. **Quản lý kho (Inventory Management)**
   - Xem tất cả sản phẩm trong kho
   - Thêm/sửa/xóa sản phẩm kho
   - Quản lý số lượng tồn kho
   - Lịch sử nhập/xuất kho

2. **Quản lý danh mục (Category Management)**
   - Thêm/sửa/xóa danh mục
   - Quản lý danh mục con
   - Thay đổi trạng thái hiển thị

3. **Quản lý sản phẩm bán (Product Listing Management)**
   - Tạo listing từ sản phẩm kho
   - Giới hạn số lượng bán
   - Đặt giá và khuyến mãi
   - Quản lý hình ảnh và mô tả

4. **Quản lý đơn hàng (Order Management)**
   - Xem danh sách đơn hàng
   - Cập nhật trạng thái đơn hàng
   - Xem chi tiết đơn hàng

5. **Quản lý người dùng (User Management)**
   - Xem danh sách khách hàng
   - Quản lý quyền admin

### Giao diện Customer

1. **Trang chủ**
   - Sản phẩm nổi bật
   - Danh mục sản phẩm
   - Banner khuyến mãi

2. **Danh sách sản phẩm**
   - Lọc theo danh mục
   - Tìm kiếm
   - Sắp xếp (giá, tên,...)

3. **Chi tiết sản phẩm**
   - Thông tin chi tiết
   - Hình ảnh
   - Thêm vào giỏ hàng

4. **Giỏ hàng**
   - Xem sản phẩm trong giỏ
   - Cập nhật số lượng
   - Thanh toán

5. **Đơn hàng của tôi**
   - Lịch sử đơn hàng
   - Theo dõi đơn hàng

## 📝 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

