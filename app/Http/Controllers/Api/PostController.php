<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePostRequest;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Store a newly created post.
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            // Auto-generate unique slug from title if not provided
            if (empty($validated['slug'])) {
                $validated['slug'] = $this->generateUniquePostSlug($validated['title']);
            }

            // Handle thumbnail upload if provided
            if ($request->hasFile('thumbnail')) {
                $path = $request->file('thumbnail')->store('posts', 'public');
                $validated['thumbnail'] = $path;
            }

            // Create post
            $post = Post::create($validated);

            // Handle tags if provided (comma-separated string)
            if (!empty($validated['tags'])) {
                $tagNames = array_map('trim', explode(',', $validated['tags']));
                $tagIds = $this->processTagNames($tagNames);
                $post->tags()->sync($tagIds);
            }

            DB::commit();

            // Load relationships
            $post->load(['category', 'user', 'tags']);

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => $post
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error creating post: ' . $e->getMessage()
            ], 500);
        }
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
                // Tag đã tồn tại, chỉ lấy ID
                $tagIds[] = $existingTag->id;
            } else {
                // Tạo tag mới với slug unique
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
     * Generate unique slug for post title
     */
    private function generateUniquePostSlug($title)
    {
        // Generate base slug
        $slug = $this->generateSlug($title);

        // Ensure uniqueness for posts table
        $originalSlug = $slug;
        $counter = 1;
        while (DB::table('posts')->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Generate slug from name (used for both posts and tags)
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
