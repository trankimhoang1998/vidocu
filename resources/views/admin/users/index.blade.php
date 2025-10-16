@extends('admin.layouts.app')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="page-header-wrapper">
    <div class="page-header">
        <div class="page-header-line"></div>
        <h1 class="page-title">Quản lý người dùng</h1>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-primary">
        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Thêm người dùng</span>
    </a>
</div>

{{-- Filter Section --}}
<div class="filter-card">
    <form action="{{ route('admin.users') }}" method="GET" class="filter-form">
        <div class="filter-group">
            <label for="search" class="form-label">Tìm kiếm</label>
            <input
                type="text"
                id="search"
                name="search"
                class="form-input"
                placeholder="Tên hoặc email..."
                value="{{ request('search') }}"
            >
        </div>

        <div class="filter-group filter-group-auto">
            <label for="role" class="form-label">Vai trò</label>
            <select id="role" name="role" class="form-select">
                <option value="">Tất cả</option>
                <option value="0" {{ request('role') === '0' ? 'selected' : '' }}>Admin</option>
                <option value="1" {{ request('role') === '1' ? 'selected' : '' }}>User</option>
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn btn-primary">
                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <span>Lọc</span>
            </button>
            <a href="{{ route('admin.users') }}" class="btn btn-outline">
                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span>Xóa lọc</span>
            </a>
        </div>
    </form>
</div>

<div class="data-table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th class="data-table-th">Tên</th>
                <th class="data-table-th">Email</th>
                <th class="data-table-th">Vai trò</th>
                <th class="data-table-th">Thời gian tạo</th>
                <th class="data-table-th data-table-th-actions">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="data-table-row">
                <td class="data-table-td">{{ $user->name }}</td>
                <td class="data-table-td">{{ $user->email }}</td>
                <td class="data-table-td">
                    <span class="badge {{ $user->isAdmin() ? 'badge-primary' : 'badge-secondary' }}">
                        {{ $user->isAdmin() ? 'Admin' : 'User' }}
                    </span>
                </td>
                <td class="data-table-td">{{ $user->created_at->format('H:i d/m/Y') }}</td>
                <td class="data-table-td data-table-td-actions">
                    <div class="data-table-actions">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn-action btn-action-edit" data-tooltip="Sửa">
                            <svg class="btn-action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <button class="btn-action btn-action-delete" data-tooltip="Xóa" onclick="showDeleteModal({{ $user->id }}, '{{ $user->name }}')">
                            <svg class="btn-action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="data-table-td data-table-empty">Chưa có dữ liệu</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($users->hasPages())
    <x-pagination :paginator="$users" />
@endif

{{-- Delete Confirmation Modal --}}
<x-modal-confirm
    id="deleteModal"
    title="Xác nhận xóa"
    message="Bạn có chắc chắn muốn xóa người dùng này? Hành động này không thể hoàn tác."
    type="danger"
    confirmText="Xóa"
    cancelText="Hủy"
/>

<script>
let deleteUserId = null;

function showDeleteModal(id, name) {
    deleteUserId = id;
    const modal = document.getElementById('deleteModal');
    const modalBody = modal.querySelector('.modal-body p');
    modalBody.innerHTML = `Bạn có chắc chắn muốn xóa người dùng <strong>${name}</strong>?<br><span style="color: #dc2626; font-size: 0.875rem;">Hành động này không thể hoàn tác!</span>`;
    modal.classList.add('modal-show');
    document.body.style.overflow = 'hidden';
}

function hideDeleteModal() {
    document.getElementById('deleteModal').classList.remove('modal-show');
    document.body.style.overflow = '';
    deleteUserId = null;
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideDeleteModal();
    }
});

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && deleteUserId) {
        hideDeleteModal();
    }
});

// Handle confirm delete
document.getElementById('deleteModal-confirm').addEventListener('click', async function() {
    if (!deleteUserId) return;

    const btn = this;
    btn.disabled = true;
    btn.textContent = 'Đang xóa...';

    try {
        const response = await fetch(`/admin/users/${deleteUserId}`, {
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
        toastr.error('Có lỗi xảy ra khi xóa người dùng!');
        btn.disabled = false;
        btn.textContent = 'Xóa';
    }
});
</script>
@endsection
