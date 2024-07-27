<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostsRequest extends FormRequest
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
        return [
            'title'=>'required|',
            'desc'=>'required|',
            'content'=>'required|',
            'image' => 'required|',
            'publish' => 'required|',
            'user_id' => 'gt:0|',
            'category_id' => 'gt:0|',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Vui lòng nhập Tiêu đề bài viết.',
            'desc.required' => 'Vui lòng nhập Tóm tắt bài viết.',
            'content.required' => 'Vui lòng nhập Nội dung bài viết.',
            'image.required' => 'Vui lòng chọn Ảnh bài viết.',
            'publish.required' => 'Vui lòng Chọn Tình Trạng Bài viết',
            'category_id.gt' => 'Vui lòng chọn Danh mục bài viết',
        ];
    }
}
