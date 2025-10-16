@extends('admin.layouts.app')

@section('title', 'Sửa danh mục')

@section('content')
<div class="page-header-wrapper">
    <div class="page-header">
        <div class="page-header-line"></div>
        <h1 class="page-title">Sửa danh mục</h1>
    </div>
</div>

<form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="form-card">
    @csrf
    @method('PUT')

    <div class="form-grid">
        <div class="form-group">
            <label for="name" class="form-label">
                Tên danh mục <span class="required">*</span>
            </label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-input @error('name') error @enderror"
                value="{{ old('name', $category->name) }}"
                placeholder="Nhập tên danh mục"
            >
            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="slug" class="form-label">
                Slug <span class="required">*</span>
            </label>
            <input
                type="text"
                id="slug"
                name="slug"
                class="form-input @error('slug') error @enderror"
                value="{{ old('slug', $category->slug) }}"
                placeholder="Nhập slug"
            >
            @error('slug')
                <span class="form-error">{{ $message }}</span>
            @enderror
            <span class="form-help">Slug sẽ được sử dụng trong URL</span>
        </div>

        <div class="form-group form-grid-full">
            <label for="parent_id" class="form-label">
                Danh mục cha
            </label>
            <select
                id="parent_id"
                name="parent_id"
                class="form-select @error('parent_id') error @enderror"
            >
                <option value="">-- Không có (Danh mục gốc) --</option>
                @foreach($parentCategories as $parentCategory)
                    <option value="{{ $parentCategory->id }}" {{ old('parent_id', $category->parent_id) == $parentCategory->id ? 'selected' : '' }}>
                        {{ str_repeat('- ', $parentCategory->level) }}{{ $parentCategory->name }}
                    </option>
                @endforeach
            </select>
            @error('parent_id')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Cập nhật danh mục</span>
        </button>
        <a href="{{ route('admin.categories') }}" class="btn btn-outline">
            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <span>Hủy</span>
        </a>
    </div>
</form>

<script>
// Auto generate slug from name
document.getElementById('name').addEventListener('input', function(e) {
    const name = e.target.value;
    const slug = name
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/đ/g, 'd')
        .replace(/Đ/g, 'd')
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-+|-+$/g, '');

    document.getElementById('slug').value = slug;
});
</script>
@endsection
