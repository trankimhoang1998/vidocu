@extends('auth.layout')

@section('title', 'Đăng nhập')

@section('content')
<div class="auth-card">
    <div class="auth-logo">
        <h1>VIDOCU</h1>
    </div>

    <form action="{{ route('login.post') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input
                type="text"
                id="email"
                name="email"
                class="form-input @error('email') error @enderror"
                value="{{ old('email') }}"
                placeholder="Nhập email"
                autofocus
            >
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Mật khẩu</label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-input @error('password') error @enderror"
                placeholder="Nhập mật khẩu"
            >
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">
                Đăng nhập
            </button>
        </div>
    </form>
</div>
@endsection
