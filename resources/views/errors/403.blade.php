<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Không có quyền truy cập</title>
    @vite(['resources/scss/app.scss'])
</head>
<body style="margin: 0; padding: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #f9fafb;">
    <div style="text-align: center; padding: 2rem;">
        <div style="font-size: 5rem; color: #dc2626; margin-bottom: 1rem;">403</div>
        <h2 style="font-size: 1.5rem; color: #374151; margin-bottom: 1rem;">Không có quyền truy cập</h2>
        <p style="color: #6b7280; margin-bottom: 2rem;">{{ $exception->getMessage() ?: 'Bạn không có quyền truy cập trang này.' }}</p>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
            Quay về Dashboard
        </a>
    </div>
</body>
</html>
