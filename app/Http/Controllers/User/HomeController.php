<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
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

    public function tags()
    {
        return view('user.tags');
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
}
