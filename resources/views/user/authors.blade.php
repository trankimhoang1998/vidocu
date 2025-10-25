@extends('user.layouts.app')

@section('title', 'Tác giả')

@push('seo')
@php
    $authorNames = $authors->take(20)->pluck('name')->join(', ');
@endphp
@include('user.partials.seo', [
    'title' => 'Danh sách Tác giả - Vidocu',
    'description' => 'Khám phá tất cả các tác giả đang chia sẻ tài liệu học tập trên Vidocu. Tìm kiếm tài liệu theo tác giả yêu thích của bạn.',
    'keywords' => $authorNames . ', tác giả, người viết, vidocu',
    'canonical' => route('authors'),
    'type' => 'website',
    'image' => asset('vidocu.png'),
    'imageAlt' => 'Danh sách Tác giả - Vidocu',
    'jsonLd' => [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => 'Danh sách Tác giả',
        'description' => 'Tất cả các tác giả tài liệu học tập trên Vidocu',
        'url' => route('authors'),
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Vidocu',
            'url' => url('/')
        ]
    ]
])
@endpush

@section('content')
<div class="authors-page">
    <div class="container">
        <div class="authors-grid" id="authors-grid">
            @include('user.partials.author-card', ['authors' => $authors])
        </div>

        @if($authors->hasMorePages())
        <div class="loading-trigger" id="loading-trigger">
            <div class="loading-spinner">Đang tải...</div>
        </div>
        @endif

        @if($authors->isEmpty())
        <div class="empty-state">
            <p>Chưa có tác giả nào.</p>
        </div>
        @endif

        <div class="back-link">
            <a href="{{ route('home') }}">← Quay lại trang chủ</a>
        </div>
    </div>
</div>

<script>
let page = 1;
let loading = false;
let hasMorePages = {{ $authors->hasMorePages() ? 'true' : 'false' }};

const loadMore = () => {
    if (loading || !hasMorePages) return;

    loading = true;
    page++;

    fetch(`{{ route('authors') }}?page=${page}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        const authorsGrid = document.getElementById('authors-grid');
        authorsGrid.insertAdjacentHTML('beforeend', data.html);

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
