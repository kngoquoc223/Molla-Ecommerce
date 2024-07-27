<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
            'coupon_name'=>'required|string',
            'coupon_code'=>'required|string',
            'coupon_time'=>'required',
            'coupon_condition'=>'gt:0',
            'coupon_number'=>'required',
            'publish' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'coupon_name.required' => 'Vui lòng nhập Tên Mã Giảm Giá.',
            'coupon_name.string' => 'Tên Mã Giảm Giá phải là dạng ký tự.',      
            'coupon_code.required' => 'Vui lòng nhập Mã Giảm Giá.',
            'coupon_code.string' => 'Mã Giảm Giá phải là dạng ký tự.',      
            'coupon_time.required' => 'Vui lòng nhập Số Lượng.',
            'coupon_condition.gt' => 'Vui lòng Chọn Tính Năng Mã Giảm Giá.',
            'coupon_number.required' => 'Nhập Giá Trị Mã Giảm Giá.',
            'publish.required' => 'Vui lòng Chọn Tình Trạng Mã Giảm Giá.',
        ];
    }
}
