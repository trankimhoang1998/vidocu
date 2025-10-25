@extends('user.layouts.app')

@section('title', 'Thẻ')

@push('seo')
@php
    $tags = \App\Models\Tag::withCount('posts')->orderBy('posts_count', 'desc')->limit(20)->get();
    $tagNames = $tags->pluck('name')->join(', ');
@endphp
@include('user.partials.seo', [
    'title' => 'Danh sách Tags - Vidocu',
    'description' => 'Khám phá tất cả các chủ đề tài liệu học tập được phân loại theo tags. Tìm kiếm tài liệu nhanh chóng qua hệ thống phân loại chi tiết.',
    'keywords' => $tagNames . ', tags, phân loại tài liệu, chủ đề học tập, vidocu',
    'canonical' => route('tags'),
    'type' => 'website',
    'image' => asset('vidocu.png'),
    'imageAlt' => 'Danh sách Tags - Vidocu',
    'jsonLd' => [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => 'Danh sách Tags',
        'description' => 'Tất cả các tags tài liệu học tập trên Vidocu',
        'url' => route('tags'),
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Vidocu',
            'url' => url('/')
        ]
    ]
])
@endpush

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
