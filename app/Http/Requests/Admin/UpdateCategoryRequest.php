<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        $categoryId = $this->route('id');

        return [
            'name' => 'required|string|max:255',
            'slug' => "required|string|max:255|unique:categories,slug,{$categoryId}",
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục là bắt buộc',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
            'slug.required' => 'Slug là bắt buộc',
            'slug.max' => 'Slug không được vượt quá 255 ký tự',
            'slug.unique' => 'Slug đã tồn tại',
            'parent_id.exists' => 'Danh mục cha không tồn tại',
        ];
    }
}
