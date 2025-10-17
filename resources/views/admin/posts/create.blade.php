@extends('admin.layouts.app')

@section('title', 'Thêm bài viết')

@section('content')
<div class="page-header-wrapper">
    <div class="page-header">
        <div class="page-header-line"></div>
        <h1 class="page-title">Thêm bài viết</h1>
    </div>
</div>

<form action="{{ route('admin.posts.store') }}" method="POST" class="form-card" enctype="multipart/form-data">
    @csrf

    <div class="form-grid">
        <div class="form-group form-grid-full">
            <label for="title" class="form-label">
                Tiêu đề <span class="required">*</span>
            </label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-input @error('title') error @enderror"
                value="{{ old('title') }}"
                placeholder="Nhập tiêu đề bài viết"
            >
            @error('title')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group form-grid-full">
            <label for="slug" class="form-label">
                Slug <span class="required">*</span>
            </label>
            <input
                type="text"
                id="slug"
                name="slug"
                class="form-input @error('slug') error @enderror"
                value="{{ old('slug') }}"
                placeholder="Nhập slug"
            >
            @error('slug')
                <span class="form-error">{{ $message }}</span>
            @enderror
            <span class="form-help">Slug sẽ được sử dụng trong URL</span>
        </div>

        <div class="form-group">
            <label for="category_id" class="form-label">
                Danh mục <span class="required">*</span>
            </label>
            <select
                id="category_id"
                name="category_id"
                class="form-select @error('category_id') error @enderror"
            >
                <option value="">-- Chọn danh mục --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ str_repeat('- ', $category->level) }}{{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="status" class="form-label">
                Trạng thái <span class="required">*</span>
            </label>
            <select
                id="status"
                name="status"
                class="form-select @error('status') error @enderror"
            >
                <option value="0" {{ old('status', 0) == 0 ? 'selected' : '' }}>Nháp</option>
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Công khai</option>
            </select>
            @error('status')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group form-grid-full">
            <label for="description" class="form-label">
                Mô tả ngắn
            </label>
            <textarea
                id="description"
                name="description"
                class="form-textarea @error('description') error @enderror"
                rows="3"
                placeholder="Nhập mô tả ngắn cho bài viết"
            >{{ old('description') }}</textarea>
            @error('description')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group form-grid-full">
            <label for="content" class="form-label">
                Nội dung <span class="required">*</span>
            </label>
            <textarea
                id="content"
                name="content"
                class="form-textarea @error('content') error @enderror"
                rows="10"
                placeholder="Nhập nội dung bài viết"
            >{{ old('content') }}</textarea>
            @error('content')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group form-grid-full">
            <label class="form-label">
                Ảnh đại diện
            </label>

            <div class="image-upload-wrapper">
                <input
                    type="file"
                    id="thumbnail"
                    name="thumbnail"
                    class="image-upload-input"
                    accept="image/*"
                    onchange="previewImage(this)"
                >

                <div class="image-preview-container" id="imagePreviewContainer" onclick="document.getElementById('thumbnail').click()">
                    <div class="image-preview-placeholder">
                        <svg class="image-preview-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="image-preview-text">Click để chọn ảnh</p>
                        <p class="image-preview-subtext">hoặc kéo thả ảnh vào đây</p>
                    </div>
                    <img id="imagePreview" class="image-preview-img" style="display: none;">

                    <div class="image-info" id="imageInfo" style="display: none;">
                        <div class="image-info-content">
                            <span id="imageName" class="image-name"></span>
                        </div>
                        <button type="button" class="image-remove-btn" onclick="removeImage(event)">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            @error('thumbnail')
                <span class="form-error">{{ $message }}</span>
            @enderror
            <span class="form-help">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB</span>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Tạo bài viết</span>
        </button>
        <a href="{{ route('admin.posts') }}" class="btn btn-outline">
            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <span>Hủy</span>
        </a>
    </div>
</form>

<script>
// Auto generate slug from title
document.getElementById('title').addEventListener('input', function(e) {
    const title = e.target.value;
    const slug = title
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

// Image upload preview
function previewImage(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            const placeholder = document.querySelector('.image-preview-placeholder');
            const imageInfo = document.getElementById('imageInfo');
            const imageName = document.getElementById('imageName');

            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
            imageInfo.style.display = 'flex';
            imageName.textContent = file.name;
        }

        reader.readAsDataURL(file);
    }
}

// Remove image
function removeImage(event) {
    event.stopPropagation();

    const input = document.getElementById('thumbnail');
    const preview = document.getElementById('imagePreview');
    const placeholder = document.querySelector('.image-preview-placeholder');
    const imageInfo = document.getElementById('imageInfo');

    input.value = '';
    preview.src = '';
    preview.style.display = 'none';
    placeholder.style.display = 'block';
    imageInfo.style.display = 'none';
}

// Drag and drop
const container = document.getElementById('imagePreviewContainer');

container.addEventListener('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
    this.style.borderColor = '#6366f1';
    this.style.background = '#f5f5ff';
});

container.addEventListener('dragleave', function(e) {
    e.preventDefault();
    e.stopPropagation();
    this.style.borderColor = '#d1d5db';
    this.style.background = '#f9fafb';
});

container.addEventListener('drop', function(e) {
    e.preventDefault();
    e.stopPropagation();
    this.style.borderColor = '#d1d5db';
    this.style.background = '#f9fafb';

    const files = e.dataTransfer.files;
    if (files.length > 0) {
        const input = document.getElementById('thumbnail');
        input.files = files;
        previewImage(input);
    }
});
</script>
@endsection
