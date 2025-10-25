@foreach($tags as $tag)
<a href="{{ route('tag.show', $tag->slug) }}" class="tag-card">
    <div class="tag-icon">#</div>
    <h3 class="tag-name">{{ $tag->name }}</h3>
    <p class="tag-count">{{ $tag->posts_count }} bài viết</p>
</a>
@endforeach
