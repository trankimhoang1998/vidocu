<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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

        // Get tags for each post
        foreach ($posts as $post) {
            $post->tags = DB::table('tags')
                ->join('post_tag', 'tags.id', '=', 'post_tag.tag_id')
                ->where('post_tag.post_id', $post->id)
                ->select('tags.id', 'tags.name', 'tags.slug')
                ->get();
        }

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
            DB::beginTransaction();

            // Handle thumbnail upload
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('posts', 'public');
            }

            $postId = DB::table('posts')->insertGetId([
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

            // Handle tags - create/get tags and link to post
            if ($request->has('tags') && $request->input('tags')) {
                $tagNames = json_decode($request->input('tags'), true);
                if (is_array($tagNames) && count($tagNames) > 0) {
                    $tagIds = $this->processTagNames($tagNames);

                    $tagData = array_map(function($tagId) use ($postId) {
                        return [
                            'post_id' => $postId,
                            'tag_id' => $tagId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }, $tagIds);

                    DB::table('post_tag')->insert($tagData);
                }
            }

            DB::commit();

            return redirect()->route('admin.posts')->with('success', 'Thêm bài viết thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
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

        // Load existing tags for the post
        $postTags = DB::table('tags')
            ->join('post_tag', 'tags.id', '=', 'post_tag.tag_id')
            ->where('post_tag.post_id', $id)
            ->select('tags.id', 'tags.name', 'tags.slug')
            ->get();

        $allCategories = DB::table('categories')->orderBy('id')->get();
        $categories = $this->buildHierarchy($allCategories);

        return view('admin.posts.edit', compact('post', 'categories', 'postTags'));
    }

    /**
     * Update post.
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

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

            // Handle tags - delete old relationships and create new ones
            DB::table('post_tag')->where('post_id', $id)->delete();

            if ($request->has('tags') && $request->input('tags')) {
                $tagNames = json_decode($request->input('tags'), true);
                if (is_array($tagNames) && count($tagNames) > 0) {
                    $tagIds = $this->processTagNames($tagNames);

                    $tagData = array_map(function($tagId) use ($id) {
                        return [
                            'post_id' => $id,
                            'tag_id' => $tagId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }, $tagIds);

                    DB::table('post_tag')->insert($tagData);
                }
            }

            DB::commit();

            return redirect()->route('admin.posts')->with('success', 'Cập nhật bài viết thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
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

    /**
     * Process tag names - create tags if they don't exist and return tag IDs
     */
    private function processTagNames($tagNames)
    {
        $tagIds = [];

        foreach ($tagNames as $tagName) {
            $tagName = trim($tagName);
            if (empty($tagName)) {
                continue;
            }

            // Check if tag exists (case-insensitive)
            $existingTag = DB::table('tags')
                ->whereRaw('LOWER(name) = ?', [strtolower($tagName)])
                ->first();

            if ($existingTag) {
                $tagIds[] = $existingTag->id;
            } else {
                // Create new tag with slug
                $slug = $this->generateSlug($tagName);

                $tagId = DB::table('tags')->insertGetId([
                    'name' => $tagName,
                    'slug' => $slug,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $tagIds[] = $tagId;
            }
        }

        return $tagIds;
    }

    /**
     * Generate slug from tag name
     */
    private function generateSlug($name)
    {
        // Method 1: Using iconv (handles Vietnamese characters)
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $name);
        $slug = strtolower(trim($slug));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        $slug = trim($slug, '-');

        // Method 2: Fallback if slug is empty (for pure Vietnamese without ASCII equivalent)
        if (empty($slug)) {
            $slug = strtolower($name);
            $slug = str_replace(
                ['á', 'à', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ',
                 'é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ',
                 'í', 'ì', 'ỉ', 'ĩ', 'ị',
                 'ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ',
                 'ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự',
                 'ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ',
                 'đ'],
                ['a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
                 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
                 'i', 'i', 'i', 'i', 'i',
                 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
                 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
                 'y', 'y', 'y', 'y', 'y',
                 'd'],
                $slug
            );
            $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
            $slug = preg_replace('/[\s-]+/', '-', $slug);
            $slug = trim($slug, '-');
        }

        // Ensure uniqueness
        $originalSlug = $slug;
        $counter = 1;
        while (DB::table('tags')->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
