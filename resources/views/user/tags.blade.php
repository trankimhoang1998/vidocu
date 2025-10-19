@extends('user.layouts.app')

@section('title', 'Thẻ')

@section('content')
<div class="tags-page">
    <div class="container">
        <div class="tags-grid" id="tags-grid">
            @php
                $tags = \App\Models\Tag::withCount('posts')->orderBy('posts_count', 'desc')->get();
            @endphp

            @forelse($tags as $tag)
            <a href="{{ route('tag.show', $tag->slug) }}" class="tag-card">
                <div class="tag-icon">#</div>
                <h3 class="tag-name">{{ $tag->name }}</h3>
                <p class="tag-count">{{ $tag->posts_count }} bài viết</p>
            </a>
            @empty
            <div class="empty-state">
                <p>Chưa có thẻ nào.</p>
            </div>
            @endforelse
        </div>

        <div class="back-link">
            <a href="{{ route('home') }}">← Quay lại trang chủ</a>
        </div>
    </div>
</div>
@endsection
