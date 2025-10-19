@extends('user.layouts.app')

@section('title', $post->title)

@section('content')
<div class="detail-page">
    <div class="container">
        <article class="post-detail">
            {{-- Post Header --}}
            <header class="post-header">
                <h1 class="post-title">{{ $post->title }}</h1>

                <div class="post-meta">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                    <span class="post-author">{{ $post->user->name ?? 'ADMIN' }}</span>
                    <span class="post-date">• {{ $post->created_at->format('d/m/Y') }}</span>
                </div>
            </header>

            {{-- Post Thumbnail --}}
            @if($post->thumbnail)
            <div class="post-thumbnail">
                <img
                    src="{{ asset('storage/' . $post->thumbnail) }}"
                    alt="{{ $post->title }}"
                    onclick="openImageModal('{{ asset('storage/' . $post->thumbnail) }}')"
                    style="cursor: pointer;"
                >
            </div>
            @endif

            {{-- Post Description --}}
            @if($post->description)
            <div class="post-description">
                <p>{{ $post->description }}</p>
            </div>
            @endif

            {{-- Post Content --}}
            <div class="post-content">
                {!! $post->content !!}
            </div>
        </article>

        {{-- Post Tags --}}
        @if($post->tags->isNotEmpty())
        <div class="post-detail-tags">
            @foreach($post->tags as $tag)
                <a href="{{ route('tag.show', $tag->slug) }}" class="tag">{{ $tag->name }}</a>
            @endforeach
        </div>
        @endif

        {{-- Back to Home --}}
        <div class="back-link">
            <a href="{{ route('home') }}">← Quay lại trang chủ</a>
        </div>
    </div>
</div>

{{-- Image Preview Modal --}}
<div class="image-modal" id="imageModal" onclick="closeImageModal(event)">
    <div class="image-modal-content">
        <button type="button" class="image-modal-close" onclick="closeImageModal(event)">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="modalImage" class="image-modal-img" src="" alt="Preview">
    </div>
</div>

<script>
// Image modal functions
function openImageModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');

    modalImage.src = imageSrc;
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeImageModal(event) {
    if (event.target.closest('.image-modal-content') && !event.target.closest('.image-modal-close')) {
        return;
    }

    const modal = document.getElementById('imageModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('imageModal');
        if (modal.classList.contains('show')) {
            closeImageModal({ target: modal });
        }
    }
});
</script>
@endsection
