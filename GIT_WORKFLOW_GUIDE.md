# Git Workflow Guide - Codespace Setup

## 📋 Lưu ý quan trọng

Codespace này đã được cấu hình để tự động bảo vệ các file thiết lập địa phương. Hãy tuân theo các quy tắc dưới đây để tránh xung đột:

## ✅ Các file được bảo vệ (không bao giờ commit)

```
.env                    # Cấu hình môi trường (không commit)
.vscode/                # Cấu hình VS Code (không commit)
.devcontainer/          # Cấu hình Codespace (không commit)
setup-php83.sh          # Script setup PHP (không commit)
start-dev.sh            # Script khởi động dev server (không commit)
ca.pem                  # Chứng chỉ SSL (không commit)
```

## 🔧 Khi cập nhật code từ GitHub

### Nếu bạn đang dùng local (máy tính):
```bash
git pull origin main
composer install        # Cài các dependencies
npm install            # Cài npm packages
```

### Nếu bạn đang dùng Codespace:
```bash
git pull origin main
composer install        # Sẽ tự động cập nhật cho PHP 8.3
npm install
npm run dev            # Chạy dev server
```

## 🚀 Khởi động Codespace

```bash
cd /workspaces/DALN_WebBanHang

# Cách 1: Chạy script
bash start-dev.sh

# Cách 2: Manual (chạy 2 terminal riêng biệt)
# Terminal 1:
cd techshop && php artisan serve --host=0.0.0.0 --port=8000

# Terminal 2:
cd techshop && npm run dev
```

## 📝 Thực hiện commit an toàn

Các file dưới đây sẽ tự động được loại trừ:

```bash
git add .
git commit -m "Thông điệp commit"
git push origin main
```

❌ Sẽ KHÔNG commit:
- `.env` (chứa credentials)
- `.vscode/tasks.json` (cấu hình VS Code)
- `setup-php83.sh` (script setup local)

✅ SẼ commit:
- `composer.lock` (cập nhật dependencies)
- `app/`, `resources/`, `routes/` (code)
- Các file logic khác

## 🔍 Kiểm tra các file sẽ commit

```bash
git status
git diff --cached     # Xem các thay đổi sẽ commit
```

## ⚡ Các vấn đề thường gặp

### Xung đột .env
**Vấn đề**: `.env` bị commit từ máy khác
**Giải pháp**:
```bash
git rm --cached techshop/.env
git commit -m "Remove .env from tracking"
git push
```

### Xung đột composer.lock
**Vấn đề**: `composer.lock` khác nhau giữa PHP 8.0 vs 8.3
**Giải pháp**:
```bash
composer install     # Cài lại dependencies
# Hoặc giữ phiên bản từ main branch
git checkout origin/main -- techshop/composer.lock
```

### Xung đột node_modules
**Vấn đề**: `npm install` cài các package khác nhau
**Giải pháp**:
```bash
rm -rf node_modules package-lock.json
npm install
```

## 📞 Hỗ trợ

Nếu có vấn đề:
1. Kiểm tra `.gitignore` của cả root và `techshop/`
2. Chạy `git status` để xem các file chưa commit
3. Chạy `git diff` để xem thay đổi chi tiết

---

**Cơ chế bảo vệ:**
- ✓ Git assume-unchanged: Bảo vệ setup scripts
- ✓ .gitignore: Loại trừ file nhạy cảm
- ✓ core.fileMode=false: Tránh xung đột quyền file

