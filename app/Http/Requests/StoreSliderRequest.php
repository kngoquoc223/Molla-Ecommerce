<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
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
            'name'=>'required|string',
            'description'=>'required',
            'thumb' => 'required',
            'publish' => 'required',
            'url' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập Tiêu Đề.',
            'name.string' => 'Tiêu Đề phải là dạng ký tự.',            
            'thumb.required' => 'Vui lòng chọn Ảnh',
            'publish.required' => 'Vui lòng Chọn Tình Trạng',
            'description.required' => 'Vui lòng nhập Mô Tả',
            'url.required' => 'Vui lòng nhập Đường Dẫn',
            'sort_by.required' => 'Vui lòng chọn Vị Trí',
            'sort_by.min' => 'Vị Trí không hợp lệ. Vui lòng thử lại',
            
            
        ];
    }
}
