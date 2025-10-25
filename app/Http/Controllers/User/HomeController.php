<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $documents = Post::with(['user', 'category', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // AJAX request - return JSON
        if ($request->ajax()) {
            $html = view('user.partials.post-item', compact('documents'))->render();

            return response()->json([
                'html' => $html,
                'hasMorePages' => $documents->hasMorePages()
            ]);
        }

        // Normal request - return view
        return view('user.home', compact('documents'));
    }

    public function show($slug)
    {
        $post = Post::with(['user', 'category', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Get related posts based on tags
        $relatedPosts = Post::with(['user', 'category', 'tags'])
            ->where('id', '!=', $post->id)
            ->where('status', 1)
            ->whereHas('tags', function($query) use ($post) {
                $query->whereIn('tags.id', $post->tags->pluck('id'));
            })
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('user.detail', compact('post', 'relatedPosts'));
    }

    public function tags(Request $request)
    {
        $tags = Tag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->paginate(20);

        // AJAX request - return JSON
        if ($request->ajax()) {
            $html = view('user.partials.tag-card', compact('tags'))->render();

            return response()->json([
                'html' => $html,
                'hasMorePages' => $tags->hasMorePages()
            ]);
        }

        return view('user.tags', compact('tags'));
    }

    public function tag(Request $request, $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $documents = Post::with(['user', 'category', 'tags'])
            ->whereHas('tags', function($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // AJAX request - return JSON
        if ($request->ajax()) {
            $html = view('user.partials.post-item', compact('documents'))->render();

            return response()->json([
                'html' => $html,
                'hasMorePages' => $documents->hasMorePages()
            ]);
        }

        // Normal request - return view
        return view('user.tag', compact('documents', 'tag'));
    }

    public function authors(Request $request)
    {
        $authors = User::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->paginate(20);

        // AJAX request - return JSON
        if ($request->ajax()) {
            $html = view('user.partials.author-card', compact('authors'))->render();

            return response()->json([
                'html' => $html,
                'hasMorePages' => $authors->hasMorePages()
            ]);
        }

        return view('user.authors', compact('authors'));
    }

    public function author(Request $request, $id)
    {
        $author = User::findOrFail($id);

        $documents = Post::with(['user', 'category', 'tags'])
            ->where('user_id', $author->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // AJAX request - return JSON
        if ($request->ajax()) {
            $html = view('user.partials.post-item', compact('documents'))->render();

            return response()->json([
                'html' => $html,
                'hasMorePages' => $documents->hasMorePages()
            ]);
        }

        // Normal request - return view
        return view('user.author', compact('documents', 'author'));
    }
}
