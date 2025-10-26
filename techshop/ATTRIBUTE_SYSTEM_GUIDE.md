# 📋 Hướng dẫn Hệ thống Thuộc tính Động (Dynamic Attribute System)

## 🎯 Mục đích
Cho phép admin tạo các trường thông tin khác nhau cho từng loại sản phẩm. Ví dụ:
- **Màn hình**: Hãng, Kích thước, Độ phân giải, Tần số quét
- **Tai nghe**: Hãng, Loại kết nối, Chống ồn
- **Bàn phím**: Hãng, Loại switch, Kết nối, LED

## 📝 Workflow Hoàn chỉnh

### Bước 1: Quản lý Danh mục & Thuộc tính
1. **Truy cập**: `Admin Panel` → `Quản lý danh mục`
2. **Chọn/Tạo danh mục**: Ví dụ "Màn hình"
3. **Click vào danh mục** để xem chi tiết
4. **Thêm thuộc tính**:
   - Click nút "Thêm thuộc tính"
   - Nhập tên: "Hãng" (không cần đơn vị)
   - Nhập tên: "Kích thước", Đơn vị: "inch"
   - Nhập tên: "Độ phân giải" (ví dụ: 1080p, 2K, 4K)
   - Nhập tên: "Tần số quét", Đơn vị: "Hz"

### Bước 2: Thêm Sản phẩm vào Kho
1. **Truy cập**: `Admin Panel` → `Quản lý kho` → `Thêm sản phẩm`
2. **Chọn danh mục**: "Màn hình"
3. **Form tự động hiển thị thêm các trường**:
   ```
   📦 Thông tin cơ bản:
   - Mã SKU: MH-ASUS-27-001
   - Tên sản phẩm: Màn hình ASUS 27 inch
   - Danh mục: Màn hình
   
   🏷️ Thông tin chi tiết sản phẩm (Tự động xuất hiện):
   - Hãng: ASUS
   - Kích thước (inch): 27
   - Độ phân giải: 2K (2560x1440)
   - Tần số quét (Hz): 144
   
   💰 Giá & Kho:
   - Giá nhập: 5,500,000 VNĐ
   - Số lượng: 50
   - Mô tả: Màn hình gaming cao cấp...
   ```

## 🔧 Cấu trúc Database

### Bảng `categories`
```sql
- id
- name (Màn hình, Tai nghe, Bàn phím...)
- slug
- parent_id
- status
```

### Bảng `product_attributes`
```sql
- id
- category_id (FK → categories.id)
- name (Hãng, Kích thước, Tần số quét...)
- unit (inch, Hz, GB... hoặc null)
```

### Bảng `inventory_items`
```sql
- id
- sku
- name
- category_id (FK → categories.id)
- cost_price
- stock_quantity
```

### Bảng `product_attribute_values`
```sql
- id
- inventory_item_id (FK → inventory_items.id)
- attribute_id (FK → product_attributes.id)
- value (ASUS, 27, 144Hz, 2K...)
```

## 💡 Ví dụ Cụ thể

### Ví dụ 1: Màn hình Gaming
**Thuộc tính trong category "Màn hình":**
- Hãng (không đơn vị)
- Kích thước (inch)
- Độ phân giải (không đơn vị)
- Tần số quét (Hz)
- Tấm nền (không đơn vị)

**Khi thêm sản phẩm "Màn hình ASUS ROG":**
- Hãng: ASUS
- Kích thước: 27
- Độ phân giải: 2K
- Tần số quét: 165
- Tấm nền: IPS

### Ví dụ 2: Tai nghe Bluetooth
**Thuộc tính trong category "Tai nghe":**
- Hãng (không đơn vị)
- Loại kết nối (không đơn vị)
- Chống ồn (không đơn vị)
- Thời lượng pin (giờ)

**Khi thêm sản phẩm "Sony WH-1000XM5":**
- Hãng: Sony
- Loại kết nối: Bluetooth 5.2
- Chống ồn: ANC
- Thời lượng pin: 30

## 🚀 Tính năng Chính

### 1. Dynamic Form Generation
- Form tự động thay đổi dựa trên category được chọn
- Chỉ hiển thị các trường liên quan đến category đó

### 2. Flexible Attributes
- Mỗi category có thể có số lượng attributes khác nhau
- Attributes có thể có hoặc không có đơn vị

### 3. Easy Management
- Thêm/Sửa/Xóa attributes trực tiếp trong trang category
- Preview ngay lập tức các trường sẽ xuất hiện

## 📊 Lợi ích

1. **Tính linh hoạt cao**: Dễ dàng thêm loại sản phẩm mới
2. **Quản lý tốt hơn**: Dữ liệu có cấu trúc, dễ tìm kiếm và lọc
3. **UX tốt**: Admin chỉ thấy các trường cần thiết cho từng loại sản phẩm
4. **Mở rộng dễ dàng**: Có thể thêm tính năng lọc/tìm kiếm theo attributes

## 🔄 Quy trình API

### Endpoint: `/admin/inventory/attributes/{category_id}`
**Request:**
```
GET /admin/inventory/attributes/1
```

**Response:**
```json
[
  {
    "id": 1,
    "category_id": 1,
    "name": "Hãng",
    "unit": null
  },
  {
    "id": 2,
    "category_id": 1,
    "name": "Kích thước",
    "unit": "inch"
  },
  {
    "id": 3,
    "category_id": 1,
    "name": "Tần số quét",
    "unit": "Hz"
  }
]
```

## ✅ Checklist Sử dụng

- [ ] Tạo categories cho tất cả loại sản phẩm
- [ ] Thêm attributes cho mỗi category
- [ ] Test form thêm sản phẩm - kiểm tra attributes hiển thị đúng
- [ ] Thêm sản phẩm thử nghiệm với đầy đủ attributes
- [ ] Xác nhận dữ liệu lưu đúng trong database

## 🎨 Screenshots

### 1. Quản lý Attributes trong Category
![Attributes Management](docs/attributes-management.png)

### 2. Dynamic Form khi Thêm Sản phẩm
![Dynamic Form](docs/dynamic-form.png)

---

**Ngày tạo**: 26/10/2025  
**Version**: 1.0  
**Cập nhật lần cuối**: 26/10/2025
