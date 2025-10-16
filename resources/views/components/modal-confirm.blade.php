@props([
    'id' => 'confirmModal',
    'title' => 'Xác nhận',
    'message' => 'Bạn có chắc chắn muốn thực hiện hành động này?',
    'type' => 'danger', // danger, warning, success, info
    'confirmText' => 'Xác nhận',
    'cancelText' => 'Hủy'
])

<div id="{{ $id }}" class="modal-overlay">
    <div class="modal-content modal-sm">
        <div class="modal-header modal-header-{{ $type }}">
            <h3 class="modal-title">
                @if($type === 'danger')
                    <svg class="modal-title-icon modal-icon-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                @elseif($type === 'warning')
                    <svg class="modal-title-icon modal-icon-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                @elseif($type === 'success')
                    <svg class="modal-title-icon modal-icon-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @else
                    <svg class="modal-title-icon modal-icon-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @endif
                <span>{{ $title }}</span>
            </h3>
            <button type="button" class="modal-close" onclick="hideDeleteModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <p>{{ $message }}</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="modal-btn modal-btn-outline" onclick="hideDeleteModal()">
                {{ $cancelText }}
            </button>
            <button type="button" class="modal-btn modal-btn-{{ $type }}" id="{{ $id }}-confirm">
                {{ $confirmText }}
            </button>
        </div>
    </div>
</div>
