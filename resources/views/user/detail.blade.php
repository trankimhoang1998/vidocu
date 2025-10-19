@extends('user.layouts.app')

@section('title', $post->title)

@push('seo')
@include('user.partials.seo', [
    'title' => $post->title . ' - Vidocu',
    'description' => $post->description ?? Str::limit(strip_tags($post->content), 160),
    'keywords' => $post->tags->pluck('name')->join(', ') . ', tài liệu học tập, vidocu',
    'canonical' => route('post.detail', $post->slug),
    'type' => 'article',
    'image' => $post->thumbnail ? asset('storage/' . $post->thumbnail) : null,
    'imageAlt' => $post->title,
    'author' => $post->user->name ?? 'Vidocu',
    'jsonLd' => [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $post->title,
        'description' => $post->description ?? Str::limit(strip_tags($post->content), 160),
        'image' => $post->thumbnail ? asset('storage/' . $post->thumbnail) : null,
        'datePublished' => $post->created_at->toIso8601String(),
        'dateModified' => $post->updated_at->toIso8601String(),
        'author' => [
            '@type' => 'Person',
            'name' => $post->user->name ?? 'Vidocu'
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Vidocu',
            'url' => url('/')
        ],
        'keywords' => $post->tags->pluck('name')->join(', '),
        'articleSection' => $post->category->name ?? 'Tài liệu',
        'wordCount' => str_word_count(strip_tags($post->content))
    ]
])
@endpush

@section('content')
<div class="detail-page">
    <div class="container">
        {{-- Breadcrumbs --}}
        @include('user.partials.breadcrumbs', [
            'breadcrumbs' => [
                [
                    'name' => $post->title,
                    'url' => route('post.detail', $post->slug)
                ]
            ]
        ])

        <article class="post-detail">
            {{-- Post Header --}}
            <header class="post-header">
                <h1 class="post-title">{{ $post->title }}</h1>

                <div class="post-meta">
                    <span class="post-author">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                        </svg>
                        {{ $post->user->name ?? 'ADMIN' }}
                    </span>
                    <span class="post-date">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                        </svg>
                        {{ $post->created_at->format('d/m/Y') }}
                    </span>
                    <span class="post-reading-time">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.2 3.2.8-1.3-4.5-2.7V7z"/>
                        </svg>
                        {{ \App\Helpers\ReadingTime::format($post->content) }}
                    </span>
                </div>
            </header>

            {{-- Post Thumbnail --}}
            @if($post->thumbnail)
            <div class="post-thumbnail">
                <img
                    src="{{ asset('storage/' . $post->thumbnail) }}"
                    alt="{{ $post->title }} - Tài liệu học tập Vidocu"
                    loading="eager"
                    decoding="async"
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

        {{-- Related Posts --}}
        @include('user.partials.related-posts', ['relatedPosts' => $relatedPosts])

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
