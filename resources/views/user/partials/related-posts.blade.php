{{-- Related Posts --}}
@if($relatedPosts->isNotEmpty())
<section class="related-posts">
    <h2 class="related-posts-title">Bài viết liên quan</h2>
    <div class="related-posts-grid">
        @foreach($relatedPosts as $doc)
        <article class="related-post-card">
            <a href="{{ route('post.detail', $doc->slug) }}" class="related-post-link">
                @if($doc->thumbnail)
                <div class="related-post-thumbnail">
                    <img
                        src="{{ asset('storage/' . $doc->thumbnail) }}"
                        alt="{{ $doc->title }} - Vidocu"
                        loading="lazy"
                        decoding="async"
                    >
                </div>
                @endif
                <div class="related-post-content">
                    <h3 class="related-post-title">{{ $doc->title }}</h3>
                    <p class="related-post-excerpt">
                        {{ Str::limit($doc->description, 100) }}
                    </p>
                    <div class="related-post-meta">
                        <span class="post-author">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                            </svg>
                            {{ $doc->user->name ?? 'ADMIN' }}
                        </span>
                        <span class="post-date">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                            </svg>
                            {{ $doc->created_at->format('d/m/Y') }}
                        </span>
                        <span class="post-reading-time">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.2 3.2.8-1.3-4.5-2.7V7z"/>
                            </svg>
                            {{ \App\Helpers\ReadingTime::format($doc->content) }}
                        </span>
                    </div>
                </div>
            </a>
        </article>
        @endforeach
    </div>
</section>
@endif
