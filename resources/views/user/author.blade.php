@extends('user.layouts.app')

@section('title', $author->name)

@push('seo')
@include('user.partials.seo', [
    'title' => $author->name . ' - Vidocu',
    'description' => 'Khám phá ' . $documents->total() . ' tài liệu học tập từ ' . $author->name . '. Tải về và chia sẻ tài liệu miễn phí trên Vidocu.',
    'keywords' => $author->name . ', tác giả, tài liệu học tập, vidocu',
    'canonical' => route('author.show', $author->id),
    'type' => 'website',
    'image' => asset('vidocu.png'),
    'imageAlt' => $author->name . ' - Tác giả Vidocu',
    'jsonLd' => [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => $author->name,
        'description' => 'Tài liệu học tập từ ' . $author->name,
        'url' => route('author.show', $author->id),
        'numberOfItems' => $documents->total(),
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Vidocu',
            'url' => url('/')
        ]
    ]
])
@endpush

@section('content')
<div class="author-page">
    <div class="container">
        {{-- Breadcrumbs --}}
        @include('user.partials.breadcrumbs', [
            'breadcrumbs' => [
                [
                    'name' => 'Tác giả',
                    'url' => route('authors')
                ],
                [
                    'name' => $author->name,
                    'url' => route('author.show', $author->id)
                ]
            ]
        ])

        {{-- Author Header --}}
        <div class="author-header">
            <div class="author-icon-large">
                <svg width="64" height="64" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                </svg>
            </div>
            <h1 class="author-title">{{ $author->name }}</h1>
            <div class="author-meta">
                <span class="author-count">{{ $documents->total() }} bài viết</span>
            </div>
        </div>

        {{-- Posts List --}}
        <div class="posts-list" id="posts-list">
            @include('user.partials.post-item', ['documents' => $documents])
        </div>

        @if($documents->hasMorePages())
        <div class="loading-trigger" id="loading-trigger">
            <div class="loading-spinner">Đang tải...</div>
        </div>
        @endif

        @if($documents->isEmpty())
        <div class="empty-state">
            <p>Chưa có bài viết nào từ tác giả này.</p>
        </div>
        @endif

        {{-- Back Links --}}
        <div class="back-links">
            <a href="{{ route('authors') }}">← Tất cả tác giả</a>
            <span class="separator">|</span>
            <a href="{{ route('home') }}">Trang chủ</a>
        </div>
    </div>
</div>

<script>
let page = 1;
let loading = false;
let hasMorePages = {{ $documents->hasMorePages() ? 'true' : 'false' }};

const loadMore = () => {
    if (loading || !hasMorePages) return;

    loading = true;
    page++;

    fetch(`{{ route('author.show', $author->id) }}?page=${page}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        const postsList = document.getElementById('posts-list');
        postsList.insertAdjacentHTML('beforeend', data.html);

        hasMorePages = data.hasMorePages;
        loading = false;

        if (!hasMorePages) {
            const trigger = document.getElementById('loading-trigger');
            if (trigger) trigger.remove();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        loading = false;
    });
};

// Intersection Observer for infinite scroll
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            loadMore();
        }
    });
}, {
    rootMargin: '100px'
});

const trigger = document.getElementById('loading-trigger');
if (trigger) {
    observer.observe(trigger);
}
</script>
@endsection
