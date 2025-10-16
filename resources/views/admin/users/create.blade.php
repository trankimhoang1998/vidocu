@extends('admin.layouts.app')

@section('title', 'Thêm người dùng')

@section('content')
<div class="page-header-wrapper">
    <div class="page-header">
        <div class="page-header-line"></div>
        <h1 class="page-title">Thêm người dùng</h1>
    </div>
</div>

<form action="{{ route('admin.users.store') }}" method="POST" class="form-card">
    @csrf

    <div class="form-grid">
        <div class="form-group">
            <label for="name" class="form-label">
                Tên <span class="required">*</span>
            </label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-input @error('name') error @enderror"
                value="{{ old('name') }}"
                placeholder="Nhập tên người dùng"
            >
            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">
                Email <span class="required">*</span>
            </label>
            <input
                type="text"
                id="email"
                name="email"
                class="form-input @error('email') error @enderror"
                value="{{ old('email') }}"
                placeholder="Nhập email"
            >
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">
                Mật khẩu <span class="required">*</span>
            </label>
            <div class="form-password-wrapper">
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-input @error('password') error @enderror"
                    placeholder="Nhập mật khẩu"
                >
                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                    <svg id="password-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
            <span class="form-help">Mật khẩu tối thiểu 8 ký tự</span>
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">
                Xác nhận mật khẩu <span class="required">*</span>
            </label>
            <div class="form-password-wrapper">
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-input"
                    placeholder="Nhập lại mật khẩu"
                >
                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                    <svg id="password_confirmation-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="form-group form-grid-full">
            <label for="role" class="form-label">
                Vai trò <span class="required">*</span>
            </label>
            <select
                id="role"
                name="role"
                class="form-select @error('role') error @enderror"
            >
                <option value="1" {{ old('role', 1) == 1 ? 'selected' : '' }}>User</option>
                <option value="0" {{ old('role') == 0 ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Tạo người dùng</span>
        </button>
        <a href="{{ route('admin.users') }}" class="btn btn-outline">
            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <span>Hủy</span>
        </a>
    </div>
</form>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId + '-eye');

    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}
</script>
@endsection
