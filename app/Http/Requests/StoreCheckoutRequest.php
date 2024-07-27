<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckoutRequest extends FormRequest
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
            'name'=>'required|string|min:8',
            'email'=>'required|string|email',
            'phone' => 'required|min:8|max:15',
            'address'=>'required|string',
            'province_id'=>'gt:0',
            'district_id' => 'gt:0',
            'ward_id' => 'gt:0',
            'method_delivery' => 'gt:0',
            'method_payment' => 'gt:0',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập Họ Tên.',
            'name.string' => 'Họ Tên phải là dạng ký tự.',      
            'name.min' => 'Họ Tên phải nhiều hơn 8 ký tự.',
            'email.string' => 'Email phải là dạng ký tự.',      
            'email.required' => 'Vui lòng nhập Email.',
            'email.email' => 'Địa chỉ Email không hợp lệ (vd:abc@gmail.com).',
            'phone.required' => 'Vui lòng nhập Số điện thoại.',
            'phone.min' => 'Số điện thoại không hợp lệ (độ dài từ 8 - 15 ký tự, không chứa ký tự đặc biệt và khoảng trắng).',
            'phone.max' => 'Số điện thoại không hợp lệ (độ dài từ 8 - 15 ký tự, không chứa ký tự đặc biệt và khoảng trắng).',
            'address.required' => 'Vui lòng nhập Địa chỉ.',
            'province_id.gt' => 'Vui lòng chọn Thành Phố',
            'district_id.gt' => 'Vui lòng chọn Quận/Huyện',
            'ward_id.gt' => 'Vui lòng chọn Phường/Xã',
            'method_delivery.gt' => 'Vui lòng chọn Phương thức vận chuyển',
            'method_payment.gt' => 'Vui lòng chọn Phương thức thanh toán',
        ];
    }
}
