<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductAttrRequest extends FormRequest
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
            'id'=>'required|gt:0',
            'publish' => 'required',
            'value' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'value.required' => 'Vui lòng Nhập Giá Trị Thuộc Tính.',
            'id.required' => 'Vui lòng Chọn Nhóm Thuộc Tính.',
            'id.gt' => 'Vui lòng Chọn Nhóm Thuộc Tính.',
            'publish.required' => 'Vui lòng Chọn Tình Trạng Thuộc Tính.'  
        ];
    }
}
