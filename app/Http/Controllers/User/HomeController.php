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

        return view('user.detail', compact('post'));
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
