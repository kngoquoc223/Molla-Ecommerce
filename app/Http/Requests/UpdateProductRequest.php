<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'price'=>'required|min:0',
            'discount'=>'min:0|',
            'name'=>'required|string',
            'category_id'=>'required|gt:0',
            'thumb' => 'required',
            'attr.*.quantity' => 'numeric|min:0',
            'attr.*.attr_value_id' => 'gt:0',
        ];
    }
    public function messages(): array
    {
        return [
            'discount.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0',
            'price.required' => 'Vui lòng nhập Đơn Giá sản phẩm.',
            'price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0',
            'name.required' => 'Vui lòng nhập Tên sản phẩm.',
            'name.string' => 'Tên sản phẩm phải là dạng ký tự.',           
            'category_id.required' => 'Vui lòng chọn Danh Mục Sản Phẩm.', 
            'category_id.gt' => 'Vui lòng chọn Danh Mục Sản Phẩm.',        
            'thumb.required' => 'Vui lòng chọn Ảnh cho Sản Phẩm',
            'attr.*.quantity.numeric' => 'Nhập Số Lượng Sản Phẩm',
            'attr.*.quantity.min' => 'Số Lượng Sản Phẩm phải lớn hơn hoặc bằng 0',
            'attr.*.attr_value_id.gt' => 'Vui lòng Chọn Thuộc Tính Sản Phẩm',
        ];
    }
}
