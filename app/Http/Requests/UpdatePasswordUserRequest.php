<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Contracts\Service\Attribute\Required;

class UpdatePasswordUserRequest extends FormRequest
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
            'password'=>'required|string|min:6',
            're_password'=>'required|string|same:password',
        ];
    }
    public function messages(): array
    {
        return [
            'password.min' => 'Mật khẩu phải nhiều hơn 6 ký tự.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            're_password.required' => 'Vui lòng nhập vào ô. Nhập lại mật khẩu.',
            're_password.same' => 'Nhập lại mật khẩu không trùng khớp.',
        ];
    }
}
