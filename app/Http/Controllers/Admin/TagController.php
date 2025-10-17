<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display tags list.
     */
    public function index()
    {
        $query = DB::table('tags')
            ->select('tags.*');

        // Filter by name
        if (request('search')) {
            $query->where('tags.name', 'like', '%' . request('search') . '%');
        }

        $tags = $query->orderBy('tags.created_at', 'desc')
            ->paginate(20)
            ->appends(request()->query());

        // Count posts for each tag
        foreach ($tags as $tag) {
            $tag->posts_count = DB::table('post_tag')
                ->where('tag_id', $tag->id)
                ->count();
        }

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show create tag form.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store new tag from form.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ], [
            'name.required' => 'Tên tag là bắt buộc',
            'name.max' => 'Tên tag không được vượt quá 255 ký tự',
            'name.unique' => 'Tag đã tồn tại',
        ]);

        try {
            $name = trim($request->input('name'));
            $slug = $this->generateSlug($name);

            DB::table('tags')->insert([
                'name' => $name,
                'slug' => $slug,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('admin.tags')->with('success', 'Thêm tag thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra khi thêm tag!');
        }
    }

    /**
     * Show edit tag form.
     */
    public function edit($id)
    {
        $tag = DB::table('tags')->where('id', $id)->first();

        if (!$tag) {
            return redirect()->route('admin.tags')->with('error', 'Tag không tồn tại!');
        }

        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update tag.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $id,
        ], [
            'name.required' => 'Tên tag là bắt buộc',
            'name.max' => 'Tên tag không được vượt quá 255 ký tự',
            'name.unique' => 'Tag đã tồn tại',
        ]);

        try {
            $name = trim($request->input('name'));
            $slug = $this->generateSlug($name);

            DB::table('tags')->where('id', $id)->update([
                'name' => $name,
                'slug' => $slug,
                'updated_at' => now(),
            ]);

            return redirect()->route('admin.tags')->with('success', 'Cập nhật tag thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra khi cập nhật tag!');
        }
    }

    /**
     * Delete tag.
     */
    public function destroy($id)
    {
        try {
            // Check if tag is being used
            $postsCount = DB::table('post_tag')->where('tag_id', $id)->count();

            if ($postsCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Không thể xóa tag vì đang được sử dụng bởi {$postsCount} bài viết!"
                ], 400);
            }

            DB::table('tags')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa tag thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa tag!'
            ], 500);
        }
    }

    /**
     * Generate slug from tag name.
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

    /**
     * Search tags for autocomplete.
     */
    public function search(Request $request)
    {
        $search = $request->input('q', '');

        $tags = DB::table('tags')
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'slug']);

        return response()->json($tags);
    }
}
