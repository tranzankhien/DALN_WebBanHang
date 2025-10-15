# TechShop - Cấu trúc Database

## 📊 Tổng quan

Database được thiết kế để quản lý website bán đồ điện tử với các tính năng:
- Tách biệt giữa **Quản lý kho** (inventory_items) và **Sản phẩm bán** (products)
- Hỗ trợ nhiều biến thể sản phẩm qua thuộc tính động
- Quản lý đơn hàng và thanh toán
- Lịch sử giao dịch kho chi tiết

## 🗂️ ERD (Entity Relationship Diagram)

```
┌─────────────────┐
│     users       │
├─────────────────┤
│ id              │──┐
│ name            │  │
│ email (unique)  │  │
│ password        │  │
│ role (enum)     │  │
│ timestamps      │  │
└─────────────────┘  │
                     │
                     │──< user_addresses
                     │──< orders
                     │──< carts
                     │──< inventory_transactions (created_by)
                     
┌─────────────────────┐
│    categories       │
├─────────────────────┤
│ id                  │──┐
│ parent_id (self FK) │  │
│ slug (unique)       │  │
│ name                │  │
│ description         │  │
│ image_url           │  │
│ status (enum)       │  │
│ display_order       │  │
│ timestamps          │  │
└─────────────────────┘  │
                         │──< inventory_items
                         │──< product_attributes

┌──────────────────────┐
│  inventory_items     │
├──────────────────────┤
│ id                   │──┐
│ sku (unique)         │  │
│ name                 │  │
│ description          │  │
│ brand                │  │
│ category_id (FK)     │◄─┘
│ cost_price           │
│ stock_quantity       │
│ timestamps           │
└──────────────────────┘
        │
        │──< products
        │──< product_attribute_values
        │──< inventory_transactions
        │──< order_items

┌──────────────────────┐
│     products         │
├──────────────────────┤
│ id                   │──┐
│ inventory_item_id(FK)│◄─┘
│ name                 │
│ description          │
│ price                │
│ discount_price       │
│ stock                │
│ max_stock            │
│ status (enum)        │
│ is_featured          │
│ display_order        │
│ published_at         │
│ timestamps           │
└──────────────────────┘
        │
        │──< product_images
        │──< cart_items
        │──< order_items

┌──────────────────────────┐
│  product_attributes      │
├──────────────────────────┤
│ id                       │──┐
│ category_id (FK)         │◄─┘
│ name (RAM, ROM, Chip)    │
│ unit (GB, inch, Hz)      │
│ timestamps               │
└──────────────────────────┘
        │
        │──< product_attribute_values

┌──────────────────────────────┐
│  product_attribute_values    │
├──────────────────────────────┤
│ id                           │
│ inventory_item_id (FK)       │◄───┐
│ attribute_id (FK)            │◄───┤
│ value                        │    │
│ timestamps                   │    │
│ UNIQUE(inventory_item_id,    │    │
│        attribute_id)         │    │
└──────────────────────────────┘    │

┌─────────────────┐
│     orders      │
├─────────────────┤
│ id              │──┐
│ user_id (FK)    │◄─┘
│ total_amount    │
│ status (enum)   │
│ shipping_name   │
│ shipping_phone  │
│ shipping_address│
│ timestamps      │
└─────────────────┘
        │
        │──< order_items
        │──< payments (1:1)

┌─────────────────────┐
│   order_items       │
├─────────────────────┤
│ id                  │
│ order_id (FK)       │◄───┐
│ product_id (FK)     │◄───┤
│ inventory_item_id(FK│◄───┤
│ quantity            │    │
│ price               │    │
│ timestamps          │    │
└─────────────────────┘    │

┌─────────────────────┐
│     payments        │
├─────────────────────┤
│ id                  │
│ order_id (FK,unique)│◄───┐
│ method (enum)       │    │
│ amount              │    │
│ status (enum)       │    │
│ transaction_id      │    │
│ paid_at             │    │
│ timestamps          │    │
└─────────────────────┘    │

┌─────────────────┐
│     carts       │
├─────────────────┤
│ id              │──┐
│ user_id(FK,uniq)│◄─┘
│ timestamps      │
└─────────────────┘
        │
        │──< cart_items

┌─────────────────────┐
│   cart_items        │
├─────────────────────┤
│ id                  │
│ cart_id (FK)        │◄───┐
│ product_id (FK)     │◄───┤
│ quantity            │    │
│ timestamps          │    │
│ UNIQUE(cart_id,     │    │
│        product_id)  │    │
└─────────────────────┘    │

┌──────────────────────────┐
│ inventory_transactions   │
├──────────────────────────┤
│ id                       │
│ inventory_item_id (FK)   │◄───┐
│ type (enum)              │    │
│ quantity                 │    │
│ reference_type           │    │
│ reference_id             │    │
│ note                     │    │
│ created_by (FK users)    │◄───┤
│ timestamps               │    │
└──────────────────────────┘    │
```

## 📋 Chi tiết các bảng

### 1. users - Người dùng

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| name | VARCHAR(100) | Tên người dùng |
| email | VARCHAR(100) | Email (unique) |
| password | VARCHAR(255) | Mật khẩu (hashed) |
| role | ENUM('customer', 'admin') | Vai trò |
| timestamps | TIMESTAMP | created_at, updated_at |

**Relationships:**
- Has Many: user_addresses, orders, inventory_transactions
- Has One: cart

---

### 2. categories - Danh mục

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| parent_id | BIGINT UNSIGNED (NULL) | Foreign Key → categories.id |
| slug | VARCHAR(100) | URL friendly (unique) |
| name | VARCHAR(100) | Tên danh mục |
| description | TEXT | Mô tả |
| image_url | VARCHAR(255) | Ảnh đại diện |
| status | ENUM('active', 'inactive') | Trạng thái |
| display_order | INT | Thứ tự hiển thị |
| timestamps | TIMESTAMP | created_at, updated_at |

**Indexes:**
- parent_id, status, slug

**Relationships:**
- Belongs To: parent (Category)
- Has Many: children (Category), inventory_items, product_attributes

---

### 3. inventory_items - Kho hàng (SKU)

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| sku | VARCHAR(50) | Mã SKU (unique) |
| name | VARCHAR(150) | Tên sản phẩm trong kho |
| description | TEXT | Mô tả |
| brand | VARCHAR(100) | Thương hiệu |
| category_id | BIGINT UNSIGNED | Foreign Key → categories.id |
| cost_price | DECIMAL(12,2) | Giá nhập |
| stock_quantity | INT | Tổng số lượng trong kho |
| timestamps | TIMESTAMP | created_at, updated_at |

**Indexes:**
- category_id, brand, sku

**Relationships:**
- Belongs To: category
- Has Many: products, attributeValues, transactions, orderItems

---

### 4. products - Sản phẩm bán (Listing)

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| inventory_item_id | BIGINT UNSIGNED | Foreign Key → inventory_items.id |
| name | VARCHAR(150) | Tên marketing |
| description | TEXT | Mô tả |
| price | DECIMAL(12,2) | Giá bán |
| discount_price | DECIMAL(12,2) | Giá khuyến mãi |
| stock | INT | Số lượng hiển thị |
| max_stock | INT | Giới hạn số lượng bán |
| status | ENUM | draft/active/inactive/out_of_stock |
| is_featured | BOOLEAN | Sản phẩm nổi bật |
| display_order | INT | Thứ tự hiển thị |
| published_at | TIMESTAMP | Thời điểm công khai |
| timestamps | TIMESTAMP | created_at, updated_at |

**Indexes:**
- inventory_item_id, status, display_order

**Relationships:**
- Belongs To: inventoryItem
- Has Many: images, cartItems, orderItems
- Has One: mainImage

---

### 5. product_images - Hình ảnh sản phẩm

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| product_id | BIGINT UNSIGNED | Foreign Key → products.id |
| image_url | VARCHAR(255) | Đường dẫn ảnh |
| is_main | BOOLEAN | Ảnh chính |
| display_order | INT | Thứ tự hiển thị |
| timestamps | TIMESTAMP | created_at, updated_at |

**Indexes:**
- product_id

**Relationships:**
- Belongs To: product

---

### 6. product_attributes - Thuộc tính sản phẩm

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| category_id | BIGINT UNSIGNED | Foreign Key → categories.id |
| name | VARCHAR(100) | Tên thuộc tính (RAM, ROM, Chip) |
| unit | VARCHAR(50) | Đơn vị (GB, inch, Hz) |
| timestamps | TIMESTAMP | created_at, updated_at |

**Indexes:**
- category_id

**Relationships:**
- Belongs To: category
- Has Many: attributeValues

---

### 7. product_attribute_values - Giá trị thuộc tính

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| inventory_item_id | BIGINT UNSIGNED | Foreign Key → inventory_items.id |
| attribute_id | BIGINT UNSIGNED | Foreign Key → product_attributes.id |
| value | VARCHAR(100) | Giá trị (8GB, 128GB,...) |
| timestamps | TIMESTAMP | created_at, updated_at |

**Indexes:**
- UNIQUE(inventory_item_id, attribute_id)
- inventory_item_id

**Relationships:**
- Belongs To: inventoryItem, attribute

---

### 8. orders - Đơn hàng

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| user_id | BIGINT UNSIGNED | Foreign Key → users.id |
| total_amount | DECIMAL(12,2) | Tổng tiền |
| status | ENUM | pending/confirmed/shipped/completed/cancelled |
| shipping_name | VARCHAR(100) | Tên người nhận |
| shipping_phone | VARCHAR(20) | SĐT người nhận |
| shipping_address | VARCHAR(255) | Địa chỉ giao hàng |
| timestamps | TIMESTAMP | created_at, updated_at |

**Indexes:**
- user_id, status, created_at

**Relationships:**
- Belongs To: user
- Has Many: items
- Has One: payment

---

### 9. order_items - Chi tiết đơn hàng

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| order_id | BIGINT UNSIGNED | Foreign Key → orders.id |
| product_id | BIGINT UNSIGNED | Foreign Key → products.id |
| inventory_item_id | BIGINT UNSIGNED | Foreign Key → inventory_items.id |
| quantity | INT | Số lượng |
| price | DECIMAL(12,2) | Giá tại thời điểm đặt |
| timestamps | TIMESTAMP | created_at, updated_at |

**Indexes:**
- order_id, product_id, inventory_item_id

**Relationships:**
- Belongs To: order, product, inventoryItem

---

### 10. payments - Thanh toán

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| order_id | BIGINT UNSIGNED | Foreign Key → orders.id (unique) |
| method | ENUM | cod/credit_card/paypal/bank_transfer |
| amount | DECIMAL(12,2) | Số tiền |
| status | ENUM | pending/paid/failed |
| transaction_id | VARCHAR(100) | Mã giao dịch |
| paid_at | TIMESTAMP | Thời gian thanh toán |
| timestamps | TIMESTAMP | created_at, updated_at |

**Indexes:**
- order_id, status

**Relationships:**
- Belongs To: order

---

### 11. carts - Giỏ hàng

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| user_id | BIGINT UNSIGNED | Foreign Key → users.id (unique) |
| timestamps | TIMESTAMP | created_at, updated_at |

**Relationships:**
- Belongs To: user
- Has Many: items

---

### 12. cart_items - Sản phẩm trong giỏ

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| cart_id | BIGINT UNSIGNED | Foreign Key → carts.id |
| product_id | BIGINT UNSIGNED | Foreign Key → products.id |
| quantity | INT | Số lượng |
| timestamps | TIMESTAMP | created_at, updated_at |

**Indexes:**
- UNIQUE(cart_id, product_id)
- cart_id, product_id

**Relationships:**
- Belongs To: cart, product

---

### 13. inventory_transactions - Lịch sử kho

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| inventory_item_id | BIGINT UNSIGNED | Foreign Key → inventory_items.id |
| type | ENUM | import/export/adjustment/return |
| quantity | INT | Số lượng thay đổi |
| reference_type | VARCHAR(50) | Loại tham chiếu |
| reference_id | BIGINT UNSIGNED | ID tham chiếu |
| note | TEXT | Ghi chú |
| created_by | BIGINT UNSIGNED | Foreign Key → users.id |
| timestamps | TIMESTAMP | created_at, updated_at |

**Indexes:**
- inventory_item_id, type, created_at

**Relationships:**
- Belongs To: inventoryItem, creator (User)

---

### 14. user_addresses - Địa chỉ người dùng

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| user_id | BIGINT UNSIGNED | Foreign Key → users.id |
| full_name | VARCHAR(100) | Tên đầy đủ |
| phone | VARCHAR(20) | Số điện thoại |
| address | VARCHAR(255) | Địa chỉ |
| city | VARCHAR(100) | Thành phố |
| district | VARCHAR(100) | Quận/huyện |
| ward | VARCHAR(100) | Phường/xã |
| is_default | BOOLEAN | Địa chỉ mặc định |
| timestamps | TIMESTAMP | created_at, updated_at |

**Indexes:**
- user_id

**Relationships:**
- Belongs To: user

---

## 🔄 Luồng dữ liệu chính

### 1. Quản lý sản phẩm
```
inventory_items (Kho) → products (Listing) → product_images
                     ↓
            product_attribute_values
```

### 2. Đặt hàng
```
users → carts → cart_items (products)
              ↓
           orders → order_items (products + inventory_items)
              ↓
          payments
```

### 3. Quản lý kho
```
inventory_items ← inventory_transactions
                ↑
              orders (khi xuất hàng)
```

## 💡 Ưu điểm thiết kế

1. **Tách biệt Kho và Bán**
   - `inventory_items`: Quản lý thực tế kho hàng
   - `products`: Quản lý sản phẩm hiển thị cho khách

2. **Linh hoạt thuộc tính**
   - Thuộc tính động theo danh mục
   - Dễ thêm thuộc tính mới

3. **Truy xuất nhanh**
   - Đầy đủ indexes cho queries phổ biến
   - Tối ưu performance

4. **Audit trail**
   - `inventory_transactions`: Lịch sử đầy đủ
   - Timestamps trên tất cả bảng

5. **Mở rộng dễ dàng**
   - Hỗ trợ danh mục con (parent_id)
   - Có thể thêm variants, reviews, ratings,...
