# Vidocu - Video Documentation Platform

Dự án quản lý và xử lý tài liệu video được xây dựng trên Laravel Framework.

## Yêu cầu hệ thống

- Docker
- Docker Compose

## Cài đặt và khởi động dự án

### 1. Clone repository

```bash
git clone <repository-url>
cd vidocu
```

### 2. Cấu hình môi trường

Copy file `.env.example` thành `.env` (nếu chưa có):

```bash
cp .env.example .env
```

File `.env` đã được cấu hình sẵn với:
- Database: MySQL
- App URL: http://localhost:8092

### 3. Khởi động Docker containers

```bash
docker-compose up -d
```

Lệnh này sẽ khởi động các containers:
- **vidocu_app** - PHP-FPM application container
- **vidocu_web** - Nginx web server (port 8092)
- **vidocu_db** - MySQL database (port 3309)
- **vidocu_phpmyadmin** - phpMyAdmin (port 8093)

### 4. Cài đặt dependencies

```bash
docker-compose exec app composer install
```

### 5. Tạo application key

```bash
docker-compose exec app php artisan key:generate
```

### 6. Chạy migrations

```bash
docker-compose exec app php artisan migrate
```

### 7. Cài đặt Node dependencies và build assets (nếu cần)

```bash
docker-compose exec app npm install
docker-compose exec app npm run build
```

## Truy cập ứng dụng

- **Web Application**: http://localhost:8092
- **phpMyAdmin**: http://localhost:8093
- **MySQL**: localhost:3309

### Thông tin database

- Host: `db` (trong container) hoặc `localhost:3309` (từ máy host)
- Database: `laravel`
- Username: `laravel`
- Password: `laravel`
- Root Password: `root`

## Các lệnh thường dùng

### Dừng containers

```bash
docker-compose down
```

### Xem logs

```bash
docker-compose logs -f
```

### Vào container app

```bash
docker-compose exec app bash
```

### Chạy artisan commands

```bash
docker-compose exec app php artisan <command>
```

### Clear cache

```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
```

### Chạy tests

```bash
docker-compose exec app php artisan test
```

### Tạo migration mới

```bash
docker-compose exec app php artisan make:migration <migration_name>
```

### Tạo model

```bash
docker-compose exec app php artisan make:model <ModelName> -m
```

### Tạo controller

```bash
docker-compose exec app php artisan make:controller <ControllerName>
```

## Cấu trúc thư mục

```
vidocu/
├── app/                # Application logic
├── bootstrap/          # Framework bootstrap
├── config/             # Configuration files
├── database/           # Migrations, seeders, factories
├── docker/             # Docker configuration files (not in git)
├── public/             # Web root directory
├── resources/          # Views, raw assets
├── routes/             # Route definitions
├── storage/            # Logs, cache, uploads
├── tests/              # Automated tests
├── vendor/             # Composer dependencies
├── docker-compose.yml  # Docker compose configuration (not in git)
└── .env                # Environment variables (not in git)
```

## AI Development Assistant - Serena MCP

Dự án này được tích hợp với **Serena MCP Server** - công cụ AI coding assistant mạnh mẽ với semantic code analysis.

### Thông tin Serena

- **Vị trí cài đặt**: `~/serena`
- **Version**: serena-agent 0.1.4
- **Python**: 3.11.13
- **Repository**: https://github.com/oraios/serena

### Tính năng chính

- ✅ **Semantic Code Retrieval** - Tìm kiếm code thông minh dựa trên ngữ nghĩa
- ✅ **Symbol-based Editing** - Chỉnh sửa code chính xác theo symbols
- ✅ **Multi-language Support** - Hỗ trợ 16+ ngôn ngữ (Python, TypeScript, PHP, Go, Rust, Java, etc.)
- ✅ **LSP Integration** - Tích hợp Language Server Protocol
- ✅ **Memory System** - Ghi nhớ context và kiến thức về project

### Khởi động Serena cho Vidocu

**Basic mode** (desktop app):
```bash
cd ~/serena
uv run serena start-mcp-server --project /Users/concrete/Documents/vidocu/vidocu
```

**IDE Assistant mode** (recommended cho development):
```bash
cd ~/serena
uv run serena start-mcp-server \
  --context ide-assistant \
  --project /Users/concrete/Documents/vidocu/vidocu \
  --mode interactive,editing
```

**With web dashboard**:
```bash
cd ~/serena
uv run serena start-mcp-server \
  --project /Users/concrete/Documents/vidocu/vidocu \
  --enable-web-dashboard true
```

### Serena Commands

**Project management**:
```bash
cd ~/serena
uv run serena project list                    # Liệt kê projects
uv run serena project add vidocu /path/to/vidocu  # Thêm project
uv run serena config edit                     # Chỉnh sửa config
```

**Configuration**:
```bash
cd ~/serena
uv run serena context list                    # Xem contexts
uv run serena mode list                       # Xem modes
```

### MCP Server Options

- `--context desktop-app` - Cho Claude Desktop (default)
- `--context ide-assistant` - Cho IDE/coding (recommended)
- `--mode interactive,editing` - Modes hoạt động
- `--transport stdio` - Protocol (default)
- `--enable-web-dashboard true` - Bật web UI
- `--log-level DEBUG` - Debug mode

### Language Support

Serena hỗ trợ semantic analysis cho:
- **PHP** (Laravel) - Full support với IntelliSense
- **TypeScript/JavaScript** - Vue, React, Node.js
- **Python** - Django, Flask
- **Go, Rust, Java, C#, Ruby, Swift** - và nhiều ngôn ngữ khác

### Kiểm tra Serena đang hoạt động

**1. Kiểm tra process đang chạy:**
```bash
ps aux | grep serena | grep -v grep
```

**2. Kiểm tra logs:**
```bash
ls -lh .serena/logs/
tail -f .serena/logs/health-checks/*.log
```

**3. Kiểm tra cache đã được tạo:**
```bash
ls -lh .serena/cache/php/
```

**4. Dấu hiệu Serena đang hoạt động:**
- ✅ Claude có thêm 26+ tools (find_symbol, get_symbols_overview, replace_symbol_body, etc.)
- ✅ Response có mention "Using `find_symbol` tool..." hoặc tools tương tự
- ✅ Logs được tạo trong `.serena/logs/`
- ✅ Cache được update trong `.serena/cache/`
- ✅ Có thể tìm symbols mà không cần read toàn bộ file

**5. Dấu hiệu Serena KHÔNG hoạt động:**
- ❌ Claude chỉ dùng built-in tools (Read, Write, Edit, Grep, Bash)
- ❌ Phải read file để tìm code
- ❌ Không có semantic search
- ❌ Không có symbol-based editing

### Prompts để test Serena

Khi Serena đang chạy, bạn có thể test với các prompts:

**Test tìm symbols:**
```
Tìm tất cả các class trong dự án Vidocu
```

**Test tìm functions:**
```
Tìm function hoặc method có tên chứa "user" trong project
```

**Test overview file:**
```
Cho tôi xem overview của file app/Models/User.php
```

**Test tìm references:**
```
Tìm tất cả nơi sử dụng class User trong project
```

**Test edit symbol:**
```
Thêm method getFullName() vào class User
```

**Kiểm tra tools available:**
```
List all available MCP tools
```

Nếu thấy các tools như `find_symbol`, `get_symbols_overview`, `find_referencing_symbols`, `replace_symbol_body`, `insert_after_symbol` → Serena đang hoạt động! ✅

## Troubleshooting

### Port đã được sử dụng

Nếu gặp lỗi port bị trùng, bạn có thể thay đổi ports trong file `docker-compose.yml`:
- Web: `8092:80`
- MySQL: `3309:3306`
- phpMyAdmin: `8093:80`

### Permission issues

```bash
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 775 /var/www/html/storage
```

### Rebuild containers

```bash
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
