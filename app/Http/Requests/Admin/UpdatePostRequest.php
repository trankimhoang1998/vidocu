<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $postId = $this->route('id');

        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $postId,
            'description' => 'nullable|string',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:0,1',
            'tags' => 'required|json',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $tags = json_decode($this->input('tags'), true);

            if (!is_array($tags)) {
                $validator->errors()->add('tags', 'Tags phải là một mảng hợp lệ');
                return;
            }

            $tagCount = count($tags);

            if ($tagCount < 1) {
                $validator->errors()->add('tags', 'Bài viết phải có ít nhất 1 tag');
            }

            if ($tagCount > 5) {
                $validator->errors()->add('tags', 'Bài viết không được có quá 5 tags');
            }

            // Validate each tag name is a non-empty string
            foreach ($tags as $tagName) {
                if (!is_string($tagName) || trim($tagName) === '') {
                    $validator->errors()->add('tags', 'Tên tag không hợp lệ');
                    break;
                }
            }
        });
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề là bắt buộc',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'slug.required' => 'Slug là bắt buộc',
            'slug.max' => 'Slug không được vượt quá 255 ký tự',
            'slug.unique' => 'Slug đã tồn tại',
            'content.required' => 'Nội dung là bắt buộc',
            'thumbnail.image' => 'File phải là ảnh',
            'thumbnail.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif',
            'thumbnail.max' => 'Kích thước ảnh không được vượt quá 2MB',
            'category_id.required' => 'Danh mục là bắt buộc',
            'category_id.exists' => 'Danh mục không tồn tại',
            'status.required' => 'Trạng thái là bắt buộc',
            'status.in' => 'Trạng thái không hợp lệ',
            'tags.required' => 'Tags là bắt buộc',
            'tags.json' => 'Tags phải ở định dạng JSON hợp lệ',
        ];
    }
}
