@extends('user.layouts.app')

@section('title', $tag->name)

@section('content')
<div class="tag-page">
    <div class="container">
        {{-- Tag Header --}}
        <div class="tag-header">
            <div class="tag-icon-large">#</div>
            <h1 class="tag-title">{{ $tag->name }}</h1>
            <div class="tag-meta">
                <span class="tag-count">{{ $documents->total() }} bài viết</span>
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
            <p>Chưa có bài viết nào với thẻ này.</p>
        </div>
        @endif

        {{-- Back Links --}}
        <div class="back-links">
            <a href="{{ route('tags') }}">← Tất cả thẻ</a>
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

    fetch(`{{ route('tag.show', $tag->slug) }}?page=${page}`, {
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
