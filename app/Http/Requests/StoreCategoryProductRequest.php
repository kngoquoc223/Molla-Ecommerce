<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryProductRequest extends FormRequest
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
            'name'=>'required|string|unique:category_products',
            'parent_id' => 'required',
            'publish' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.unique' => 'Tên Danh Mục đã tồn tại.',
            'name.required' => 'Vui lòng nhập Tên Danh Mục.',
            'name.string' => 'Tên Danh Mục phải là dạng ký tự.',
            'parent_id.required' => 'Vui lòng chọn Danh Mục.',
            'publish.required' => 'Vui lòng Chọn Tình Trạng Danh Mục'
            
        ];
    }
}
