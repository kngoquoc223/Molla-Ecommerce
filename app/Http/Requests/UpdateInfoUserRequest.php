<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Contracts\Service\Attribute\Required;

class UpdateInfoUserRequest extends FormRequest
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
            'email'=>'required|string|email|max:191',
            'name'=>'required|string|min:8|',
            'user_catalogue_id'=>'gt:0',
            'province_id'=>'gt:0',
            'district_id'=>'gt:0',
            'ward_id'=>'gt:0',
            'address' => 'required',
            'phone' => 'required|numeric|digits_between:8,15',
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng. Ví dụ abc@gmail.com.',
            'email.string' => 'Email phải là dạng ký tự.',
            'email.max' => 'Độ dài email tối đa 191 ký tự.',
            'name.required' => 'Vui lòng nhập Tên người dùng.',
            'name.min' => 'Tên người dùng phải lớn hơn 8 ký tự.',
            'name.string' => 'Tên người dùng phải là dạng ký tự.',
            'user_catalogue_id.gt'=>'Chưa chọn nhóm thành viên.',
            'province_id.gt'=>'Vui lòng chọn Thành phố',
            'district_id.gt'=>'Vui lòng chọn Quận huyện',
            'ward_id.gt'=>'Vui lòng chọn Phường xã',
            'address.required'=>'Vui lòng nhập Địa chỉ',
            'phone.required'=>'Vui lòng nhập Số điện thoại',
            'phone.numeric' => 'Số điện thoại không hợp lệ (độ dài từ 8 - 15 ký tự, không chứa ký tự đặc biệt và khoảng trắng).',
            'phone.digits_between' => 'Số điện thoại không hợp lệ (độ dài từ 8 - 15 ký tự, không chứa ký tự đặc biệt và khoảng trắng).',
        ];
    }
}
