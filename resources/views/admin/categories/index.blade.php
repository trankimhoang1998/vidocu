@extends('admin.layouts.app')

@section('title', 'Quản lý danh mục')

@section('content')
<div class="page-header-wrapper">
    <div class="page-header">
        <div class="page-header-line"></div>
        <h1 class="page-title">Quản lý danh mục</h1>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn-primary">
        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Thêm danh mục</span>
    </a>
</div>

<div class="category-list">
    @forelse($categories as $category)
    <div class="category-item {{ $category->level > 0 ? 'category-item--level-' . $category->level : '' }}">
        <div class="category-item__content">
            @if($category->level > 0)
                <span class="category-item__prefix">-</span>
            @endif
            <span class="category-item__name">{{ $category->name }}</span>
            <span class="category-item__slug">({{ $category->slug }})</span>
        </div>
        <div class="category-item__actions">
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn-action btn-action-edit" data-tooltip="Sửa">
                <svg class="btn-action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </a>
            <button class="btn-action btn-action-delete" data-tooltip="Xóa" onclick="showDeleteModal({{ $category->id }}, '{{ $category->name }}')">
                <svg class="btn-action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    </div>
    @empty
    <div class="category-item">
        <div class="category-item__content">
            <span style="color: #6b7280;">Chưa có danh mục nào</span>
        </div>
    </div>
    @endforelse
</div>

{{-- Delete Confirmation Modal --}}
<x-modal-confirm
    id="deleteModal"
    title="Xác nhận xóa"
    message="Bạn có chắc chắn muốn xóa danh mục này? Hành động này không thể hoàn tác."
    type="danger"
    confirmText="Xóa"
    cancelText="Hủy"
/>

<script>
let deleteCategoryId = null;

function showDeleteModal(id, name) {
    deleteCategoryId = id;
    const modal = document.getElementById('deleteModal');
    const modalBody = modal.querySelector('.modal-body p');
    modalBody.innerHTML = `Bạn có chắc chắn muốn xóa danh mục <strong>${name}</strong>?<br><span style="color: #dc2626; font-size: 0.875rem;">Hành động này không thể hoàn tác!</span>`;
    modal.classList.add('modal-show');
    document.body.style.overflow = 'hidden';
}

function hideDeleteModal() {
    document.getElementById('deleteModal').classList.remove('modal-show');
    document.body.style.overflow = '';
    deleteCategoryId = null;
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideDeleteModal();
    }
});

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && deleteCategoryId) {
        hideDeleteModal();
    }
});

// Handle confirm delete
document.getElementById('deleteModal-confirm').addEventListener('click', async function() {
    if (!deleteCategoryId) return;

    const btn = this;
    btn.disabled = true;
    btn.textContent = 'Đang xóa...';

    try {
        const response = await fetch(`/admin/categories/${deleteCategoryId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            toastr.success(data.message);
            hideDeleteModal();

            // Reload page after short delay
            setTimeout(() => {
                window.location.reload();
            }, 500);
        } else {
            toastr.error(data.message);
            btn.disabled = false;
            btn.textContent = 'Xóa';
        }
    } catch (error) {
        toastr.error('Có lỗi xảy ra khi xóa danh mục!');
        btn.disabled = false;
        btn.textContent = 'Xóa';
    }
});
</script>
@endsection
