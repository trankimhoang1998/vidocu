@extends('admin.layouts.app')

@section('title', 'Thêm tag')

@section('content')
<div class="page-header-wrapper">
    <div class="page-header">
        <div class="page-header-line"></div>
        <h1 class="page-title">Thêm tag</h1>
    </div>
</div>

<form action="{{ route('admin.tags.store') }}" method="POST" class="form-card">
    @csrf

    <div class="form-grid">
        <div class="form-group form-grid-full">
            <label for="name" class="form-label">
                Tên tag <span class="required">*</span>
            </label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-input @error('name') error @enderror"
                value="{{ old('name') }}"
                placeholder="Nhập tên tag"
                autofocus
            >
            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror
            <span class="form-help">Slug sẽ được tự động tạo từ tên tag</span>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Tạo tag</span>
        </button>
        <a href="{{ route('admin.tags') }}" class="btn btn-outline">
            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <span>Hủy</span>
        </a>
    </div>
</form>
@endsection
