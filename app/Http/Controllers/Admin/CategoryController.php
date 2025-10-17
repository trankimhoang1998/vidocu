<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $allCategories = Category::orderBy('id')->get();
        $categories = $this->buildHierarchy($allCategories);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $allCategories = Category::orderBy('id')->get();
        $parentCategories = $this->buildHierarchy($allCategories);

        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            Category::create($request->validated());

            return redirect()->route('admin.categories')
                ->with('success', 'Thêm danh mục thành công!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi thêm danh mục!');
        }
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $allCategories = Category::where('id', '!=', $id)->orderBy('id')->get();
        $parentCategories = $this->buildHierarchy($allCategories);

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update($request->validated());

            return redirect()->route('admin.categories')
                ->with('success', 'Cập nhật danh mục thành công!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật danh mục!');
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            // Kiểm tra xem category có bài viết hay không
            if ($category->posts()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa danh mục này vì đang có bài viết!'
                ], 422);
            }

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa danh mục thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa danh mục!'
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
