@foreach($documents as $doc)
<article class="post-item">
    <div class="post-link">
        <div class="post-info">
            <a href="{{ route('post.detail', $doc->slug) }}">
                <h2 class="post-title">{{ $doc->title }}</h2>
            </a>
            <p class="post-excerpt">
                {{ Str::limit($doc->description, 200) }}
            </p>
            <div class="post-meta">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                </svg>
                <span class="post-date">{{ $doc->created_at->format('M d') }}</span>
                <span class="post-author">• {{ $doc->user->name ?? 'ADMIN' }}</span>
            </div>
            @if($doc->tags->isNotEmpty())
            <div class="post-tags">
                @foreach($doc->tags as $tag)
                    <a href="{{ route('tag.show', $tag->slug) }}" class="tag">{{ $tag->name }}</a>
                @endforeach
            </div>
            @endif
        </div>
        @if($doc->thumbnail)
        <a href="{{ route('post.detail', $doc->slug) }}" class="post-thumbnail">
            <img src="{{ asset('storage/' . $doc->thumbnail) }}" alt="{{ $doc->title }}">
        </a>
        @endif
    </div>
</article>
@endforeach
