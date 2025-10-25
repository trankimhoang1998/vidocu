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

        <div class="detail-wrapper">
            {{-- Table of Contents Sidebar --}}
            {{-- @include('user.partials.table-of-contents') --}}

            <article class="post-detail">
                {{-- Post Header --}}
                <header class="post-header">
                    <h1 class="post-title">{{ $post->title }}</h1>

                    <div class="post-meta-wrapper">
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

                        <div class="post-share">
                            <button type="button" class="share-button" onclick="toggleShareMenu(event)">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/>
                                </svg>
                                Share
                            </button>

                            <div class="share-menu" id="shareMenu">
                                <button type="button" class="share-option" onclick="copyPostLink()">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/>
                                    </svg>
                                    Copy link
                                </button>
                                <button type="button" class="share-option" onclick="shareToFacebook()">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    Share to Facebook
                                </button>
                            </div>
                        </div>
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

                {{-- Post Tags --}}
                @if($post->tags->isNotEmpty())
                <div class="post-detail-tags">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('tag.show', $tag->slug) }}" class="tag">{{ $tag->name }}</a>
                    @endforeach
                </div>
                @endif

                {{-- Related Posts --}}
                <div class="post-related">
                    @include('user.partials.related-posts', ['relatedPosts' => $relatedPosts])
                </div>

                {{-- Back to Home --}}
                <div class="back-link">
                    <a href="{{ route('home') }}">← Quay lại trang chủ</a>
                </div>
            </article>
        </div>{{-- End detail-wrapper --}}
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

{{-- Toast Notification --}}
<div class="toast-notification" id="toastNotification">
    <span class="toast-message" id="toastMessage"></span>
    <button type="button" class="toast-close" onclick="closeToast()">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
        </svg>
    </button>
</div>

{{-- Back to Top Button --}}
<button type="button" class="back-to-top" id="backToTop" onclick="scrollToTop()">
    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
        <path d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6-6 6z"/>
    </svg>
</button>

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

// Share menu functions
function toggleShareMenu(event) {
    event.stopPropagation();
    const shareMenu = document.getElementById('shareMenu');
    shareMenu.classList.toggle('show');
}

// Copy link to clipboard
function copyPostLink() {
    const url = window.location.href;

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(function() {
            showToast('Copied link to clipboard');
            closeShareMenu();
        }).catch(function(err) {
            console.error('Failed to copy: ', err);
            showToast('Failed to copy link');
        });
    } else {
        // Fallback for older browsers
        const tempInput = document.createElement('input');
        tempInput.value = url;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        showToast('Copied link to clipboard');
        closeShareMenu();
    }
}

// Share to Facebook
function shareToFacebook() {
    const url = encodeURIComponent(window.location.href);
    const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
    window.open(facebookUrl, '_blank');
    closeShareMenu();
}

// Close share menu
function closeShareMenu() {
    const shareMenu = document.getElementById('shareMenu');
    shareMenu.classList.remove('show');
}

// Close share menu when clicking outside
document.addEventListener('click', function(event) {
    const shareMenu = document.getElementById('shareMenu');
    const shareButton = event.target.closest('.share-button');

    if (!shareButton && !event.target.closest('.share-menu')) {
        closeShareMenu();
    }
});

// Toast notification functions
let toastTimeout;

function showToast(message) {
    const toast = document.getElementById('toastNotification');
    const toastMessage = document.getElementById('toastMessage');

    toastMessage.textContent = message;
    toast.classList.add('show');

    // Clear existing timeout
    if (toastTimeout) {
        clearTimeout(toastTimeout);
    }

    // Auto hide after 3 seconds
    toastTimeout = setTimeout(function() {
        closeToast();
    }, 3000);
}

function closeToast() {
    const toast = document.getElementById('toastNotification');
    toast.classList.remove('show');

    if (toastTimeout) {
        clearTimeout(toastTimeout);
    }
}

// Back to top functions
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Show/hide back to top button
window.addEventListener('scroll', function() {
    const backToTopBtn = document.getElementById('backToTop');
    if (window.scrollY > 300) {
        backToTopBtn.classList.add('show');
    } else {
        backToTopBtn.classList.remove('show');
    }
});
</script>
@endsection
