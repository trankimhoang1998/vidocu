<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'nullable|integer|in:0,1',
            'tags' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề bài viết là bắt buộc',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'slug.unique' => 'Slug này đã tồn tại',
            'content.required' => 'Nội dung bài viết là bắt buộc',
            'thumbnail.image' => 'File phải là ảnh',
            'thumbnail.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, webp',
            'thumbnail.max' => 'Kích thước ảnh không được vượt quá 2MB',
            'category_id.required' => 'Danh mục là bắt buộc',
            'category_id.exists' => 'Danh mục không tồn tại',
            'user_id.required' => 'Tác giả là bắt buộc',
            'user_id.exists' => 'Người dùng không tồn tại',
            'status.in' => 'Trạng thái không hợp lệ (0: Draft, 1: Public)',
            'tags.string' => 'Tags phải là chuỗi ký tự',
        ];
    }
}
