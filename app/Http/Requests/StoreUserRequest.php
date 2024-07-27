<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Contracts\Service\Attribute\Required;

class StoreUserRequest extends FormRequest
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
            'email'=>'required|string|email|unique:users|max:191',
            'name'=>'required|string|min:8',
            'user_catalogue_id'=>'gt:0',
            'password'=>'required|string|min:6',
            're_password'=>'required|string|same:password',
            'phone' => 'required|numeric|digits_between:8,15',
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Vui lòng nhập Email.',
            'email.email' => 'Email không đúng định dạng. Ví dụ abc@gmail.com.',
            'email.unique' => 'Email đã tồn tại.',
            'email.string' => 'Email phải là dạng ký tự.',
            'email.max' => 'Độ dài email tối đa 191 ký tự.',
            'name.required' => 'Vui lòng nhập Tên người dùng.',
            'name.min' => 'Tên người dùng phải lớn hơn 8 ký tự.',
            'name.string' => 'Tên người dùng phải là dạng ký tự.',
            'user_catalogue_id.gt'=>'Chưa chọn nhóm thành viên.',
            'password.required' => 'Vui lòng nhập Mật khẩu.',
            're_password.required' => 'Vui lòng nhập vào ô. Nhập lại mật khẩu.',
            're_password.same' => 'Mật khẩu không trùng khớp.',
            'phone.required'=> 'Vui lòng nhập Số điện thoại.',
            'phone.numeric' => 'Số điện thoại không hợp lệ (độ dài từ 8 - 15 ký tự, không chứa ký tự đặc biệt và khoảng trắng).',
            'phone.digits_between' => 'Số điện thoại không hợp lệ (độ dài từ 8 - 15 ký tự, không chứa ký tự đặc biệt và khoảng trắng).',
        ];
    }
}
