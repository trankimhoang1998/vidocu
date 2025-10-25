@extends('user.layouts.app')

@section('title', 'Trang chủ')

@push('seo')
@include('user.partials.seo', [
    'title' => 'Vidocu - Chia sẻ tài liệu học tập miễn phí',
    'description' => 'Nền tảng chia sẻ tài liệu học tập miễn phí với hàng ngàn tài liệu chất lượng cao. Tìm kiếm, tải xuống và chia sẻ tài liệu học tập dễ dàng.',
    'keywords' => 'tài liệu học tập, chia sẻ tài liệu, tài liệu miễn phí, học online, vidocu, tài liệu sinh viên, tài liệu học sinh',
    'canonical' => route('home'),
    'type' => 'website',
    'image' => asset('vidocu.png'),
    'imageAlt' => 'Vidocu - Nền tảng chia sẻ tài liệu học tập',
    'jsonLd' => [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'Vidocu',
        'url' => url('/'),
        'description' => 'Nền tảng chia sẻ tài liệu học tập miễn phí',
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Vidocu',
            'url' => url('/')
        ],
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => url('/').'?q={search_term_string}',
            'query-input' => 'required name=search_term_string'
        ]
    ]
])
@endpush

@section('content')
<div class="home-page">
    <div class="container">
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
            <p>Chưa có tài liệu nào.</p>
        </div>
        @endif
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

    fetch(`{{ route('home') }}?page=${page}`, {
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
