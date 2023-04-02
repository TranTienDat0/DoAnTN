<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'role' => 'Vui lòng chọn quyền đăng nhập',
        ];
    }
}
