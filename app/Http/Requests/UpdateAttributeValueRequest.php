<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributeValueRequest extends FormRequest
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
            'id_attribute'=>'required|gt:0',
            'value' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'value.required' => 'Vui lòng Nhập Giá Trị Thuộc Tính.',
            'id_attribute.required' => 'Vui lòng Chọn Nhóm Thuộc Tính.',
            'id_attribute.gt' => 'Vui lòng Chọn Nhóm Thuộc Tính.',
        ];
    }
}
