<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255|string',
            'email_address' => 'required|email',
            'password' => 'required|min:8',
            'address' => 'required|max:255|string',
            'phone' => 'required|size:10|',
            'role' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên của bạn.',
            'max' => 'Không nhập quá 255 kí tự',
            'min' => 'Mật khẩu tối thiểu 8 kí tự',
            'email_address.required' => 'Vui lòng nhập địa chỉ email.',
            'email' => 'Vui lòng nhập đúng định dạng email: example@gmail.com.',
            'password.required' => 'Vui lòng nhập password',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'role' => 'Vui lòng chọn quyền đăng nhập',
        ];
    }
}
