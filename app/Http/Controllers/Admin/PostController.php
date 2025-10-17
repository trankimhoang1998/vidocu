<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display posts list.
     */
    public function index()
    {
        $query = DB::table('posts')
            ->leftJoin('categories', 'posts.category_id', '=', 'categories.id')
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->select(
                'posts.*',
                'categories.name as category_name',
                'users.name as author_name'
            );

        // Filter by title
        if (request('search')) {
            $query->where('posts.title', 'like', '%' . request('search') . '%');
        }

        // Filter by category
        if (request('category')) {
            $query->where('posts.category_id', request('category'));
        }

        // Filter by status
        if (request('status') !== null && request('status') !== '') {
            $query->where('posts.status', request('status'));
        }

        $posts = $query->orderBy('posts.created_at', 'desc')
            ->paginate(10)
            ->appends(request()->query());

        // Get all categories for filter
        $allCategories = DB::table('categories')->orderBy('id')->get();
        $categories = $this->buildHierarchy($allCategories);

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show create post form.
     */
    public function create()
    {
        $allCategories = DB::table('categories')->orderBy('id')->get();
        $categories = $this->buildHierarchy($allCategories);

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store new post.
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        try {
            // Handle thumbnail upload
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('posts', 'public');
            }

            DB::table('posts')->insert([
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'description' => $validated['description'] ?? null,
                'content' => $validated['content'],
                'thumbnail' => $thumbnailPath,
                'category_id' => $validated['category_id'],
                'user_id' => auth()->id(),
                'status' => $validated['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('admin.posts')->with('success', 'Thêm bài viết thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra khi thêm bài viết!');
        }
    }

    /**
     * Show edit post form.
     */
    public function edit($id)
    {
        $post = DB::table('posts')->where('id', $id)->first();

        if (!$post) {
            return redirect()->route('admin.posts')->with('error', 'Bài viết không tồn tại!');
        }

        $allCategories = DB::table('categories')->orderBy('id')->get();
        $categories = $this->buildHierarchy($allCategories);

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update post.
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            // Get current post
            $post = DB::table('posts')->where('id', $id)->first();

            // Handle thumbnail upload
            $thumbnailPath = $post->thumbnail;

            // Check if user wants to remove the image
            if ($request->input('remove_thumbnail') == '1') {
                if ($post->thumbnail) {
                    \Storage::disk('public')->delete($post->thumbnail);
                }
                $thumbnailPath = null;
            }
            // Check if new image uploaded
            elseif ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($post->thumbnail) {
                    \Storage::disk('public')->delete($post->thumbnail);
                }
                $thumbnailPath = $request->file('thumbnail')->store('posts', 'public');
            }

            DB::table('posts')->where('id', $id)->update([
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'description' => $validated['description'] ?? null,
                'content' => $validated['content'],
                'thumbnail' => $thumbnailPath,
                'category_id' => $validated['category_id'],
                'status' => $validated['status'],
                'updated_at' => now(),
            ]);

            return redirect()->route('admin.posts')->with('success', 'Cập nhật bài viết thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra khi cập nhật bài viết!');
        }
    }

    /**
     * Delete post.
     */
    public function destroy($id)
    {
        try {
            $post = DB::table('posts')->where('id', $id)->first();

            // Delete thumbnail if exists
            if ($post && $post->thumbnail) {
                \Storage::disk('public')->delete($post->thumbnail);
            }

            DB::table('posts')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa bài viết thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa bài viết!'
            ], 500);
        }
    }

    private function buildHierarchy($categories, $parentId = null, $level = 0)
    {
        $result = [];

        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $category->level = $level;
                $result[] = $category;

                $children = $this->buildHierarchy($categories, $category->id, $level + 1);
                $result = array_merge($result, $children);
            }
        }

        return $result;
    }
}
