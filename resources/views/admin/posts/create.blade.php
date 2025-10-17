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
            <label for="tags" class="form-label">
                Tags <span class="required">*</span>
            </label>
            <div class="tag-input-wrapper">
                <div class="tag-input-container" id="tagInputContainer">
                    <div class="tags-display" id="tagsDisplay"></div>
                    <input
                        type="text"
                        class="tag-input-field"
                        id="tagInput"
                        placeholder="Nhập tag và nhấn Enter (tối thiểu 1, tối đa 5)"
                        autocomplete="off"
                    >
                </div>
                <div class="tag-autocomplete" id="tagAutocomplete" style="display: none;"></div>
            </div>
            <div class="tag-counter" id="tagCounter">
                <span class="tag-counter-text">
                    <span id="tagCount">0</span>/5 tags
                </span>
                <span class="form-help">Nhấn Enter để thêm tag</span>
            </div>
            @error('tags')
                <span class="form-error">{{ $message }}</span>
            @enderror
            <input type="hidden" name="tags" id="tagsInput" value="">
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

// Tag Input Component
(function() {
    const MIN_TAGS = 1;
    const MAX_TAGS = 5;
    let selectedTags = [];
    let searchTimeout;
    let activeIndex = -1;
    let availableTags = [];

    const tagInput = document.getElementById('tagInput');
    const tagInputContainer = document.getElementById('tagInputContainer');
    const tagsDisplay = document.getElementById('tagsDisplay');
    const tagAutocomplete = document.getElementById('tagAutocomplete');
    const tagCounter = document.getElementById('tagCounter');
    const tagCount = document.getElementById('tagCount');
    const tagsHiddenInput = document.getElementById('tagsInput');

    // Focus container when clicking on it
    tagInputContainer.addEventListener('click', function() {
        tagInput.focus();
    });

    // Handle container focus
    tagInput.addEventListener('focus', function() {
        tagInputContainer.classList.add('focused');
    });

    tagInput.addEventListener('blur', function() {
        setTimeout(() => {
            tagInputContainer.classList.remove('focused');
            hideAutocomplete();
        }, 200);
    });

    // Handle input
    tagInput.addEventListener('input', function(e) {
        const value = e.target.value.trim();

        clearTimeout(searchTimeout);

        if (value.length > 0) {
            searchTimeout = setTimeout(() => {
                searchTags(value);
            }, 300);
        } else {
            hideAutocomplete();
        }
    });

    // Handle keyboard events
    tagInput.addEventListener('keydown', function(e) {
        const value = this.value.trim();

        if (e.key === 'Enter') {
            e.preventDefault();

            if (activeIndex >= 0 && availableTags.length > 0) {
                // Select highlighted item from autocomplete
                addTag(availableTags[activeIndex]);
            } else if (value) {
                // Add tag by name (will be created in DB when post is submitted)
                addTagByName(value);
            }
        } else if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (availableTags.length > 0) {
                activeIndex = Math.min(activeIndex + 1, availableTags.length - 1);
                updateActiveItem();
            }
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (availableTags.length > 0) {
                activeIndex = Math.max(activeIndex - 1, 0);
                updateActiveItem();
            }
        } else if (e.key === 'Escape') {
            hideAutocomplete();
        } else if (e.key === 'Backspace' && !value && selectedTags.length > 0) {
            const lastTag = selectedTags[selectedTags.length - 1];
            removeTag(lastTag.id || lastTag.name);
        }
    });

    // Search tags from database
    function searchTags(query) {
        fetch(`{{ route('admin.tags.search') }}?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                availableTags = data.filter(tag => !selectedTags.find(t => t.id === tag.id));
                showAutocomplete(query);
            })
            .catch(error => {
                console.error('Error searching tags:', error);
            });
    }

    // Show autocomplete dropdown
    function showAutocomplete(query) {
        if (availableTags.length > 0) {
            tagAutocomplete.innerHTML = availableTags.map((tag, index) => `
                <div class="tag-autocomplete-item ${index === activeIndex ? 'active' : ''}"
                     onclick="addTag(${JSON.stringify(tag).replace(/"/g, '&quot;')})">
                    ${escapeHtml(tag.name)}
                </div>
            `).join('');
            tagAutocomplete.style.display = 'block';
            activeIndex = -1;
        } else {
            hideAutocomplete();
        }
    }

    // Hide autocomplete
    function hideAutocomplete() {
        tagAutocomplete.style.display = 'none';
        activeIndex = -1;
        availableTags = [];
    }

    // Update active item in autocomplete
    function updateActiveItem() {
        const items = tagAutocomplete.querySelectorAll('.tag-autocomplete-item');
        items.forEach((item, index) => {
            if (index === activeIndex) {
                item.classList.add('active');
                item.scrollIntoView({ block: 'nearest' });
            } else {
                item.classList.remove('active');
            }
        });
    }

    // Add existing tag from autocomplete
    function addTag(tag) {
        if (selectedTags.length >= MAX_TAGS) {
            alert(`Bạn chỉ có thể thêm tối đa ${MAX_TAGS} tags!`);
            return;
        }

        // Silently ignore if tag already exists (check by name, case-insensitive)
        if (selectedTags.find(t => t.name.toLowerCase() === tag.name.toLowerCase())) {
            tagInput.value = '';
            hideAutocomplete();
            return;
        }

        selectedTags.push(tag);
        renderTags();
        tagInput.value = '';
        hideAutocomplete();
        updateCounter();
        updateHiddenInput();
    }

    // Add new tag by name (will be created in DB when post is submitted)
    function addTagByName(name) {
        if (selectedTags.length >= MAX_TAGS) {
            alert(`Bạn chỉ có thể thêm tối đa ${MAX_TAGS} tags!`);
            return;
        }

        // Silently ignore if tag with same name already selected (case-insensitive)
        if (selectedTags.find(t => t.name.toLowerCase() === name.toLowerCase())) {
            tagInput.value = '';
            hideAutocomplete();
            return;
        }

        // Add tag without ID (will be created during post submission)
        selectedTags.push({ name: name });
        renderTags();
        tagInput.value = '';
        hideAutocomplete();
        updateCounter();
        updateHiddenInput();
    }

    // Remove tag by ID or name
    function removeTag(identifier) {
        selectedTags = selectedTags.filter(t => {
            if (t.id) {
                return t.id !== identifier;
            } else {
                return t.name !== identifier;
            }
        });
        renderTags();
        updateCounter();
        updateHiddenInput();
    }

    // Render tags display
    function renderTags() {
        tagsDisplay.innerHTML = selectedTags.map(tag => {
            const identifier = tag.id || tag.name;
            const identifierStr = typeof identifier === 'string' ? `'${escapeHtml(identifier)}'` : identifier;
            return `
                <div class="tag-item">
                    <span class="tag-item-text">${escapeHtml(tag.name)}</span>
                    <button type="button" class="tag-item-remove" onclick="removeTagById(${identifierStr})">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            `;
        }).join('');
    }

    // Update counter
    function updateCounter() {
        tagCount.textContent = selectedTags.length;

        tagCounter.classList.remove('warning', 'error');
        tagInputContainer.classList.remove('error');

        if (selectedTags.length >= MAX_TAGS) {
            tagCounter.classList.add('error');
            tagInput.disabled = true;
        } else {
            tagInput.disabled = false;
            if (selectedTags.length === MAX_TAGS - 1) {
                tagCounter.classList.add('warning');
            }
        }
    }

    // Update hidden input with tag names
    function updateHiddenInput() {
        tagsHiddenInput.value = JSON.stringify(selectedTags.map(t => t.name));
    }

    // Escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Global function to remove tag (called from onclick)
    window.removeTagById = function(identifier) {
        removeTag(identifier);
    };

    // Make addTag global for onclick
    window.addTag = addTag;
})();

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
