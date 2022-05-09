<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'password'      => 'required|min:5|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'password.required'     => ':attribute không được để trống',
            'password.min'          => ':attribute phải lớn hơn :min ký tự',
            'password.confirmed'    => ':attribute không trùng khớp'
        ];
    }

    public function attributes()
    {
        return [
            'password'      => 'Mật khẩu'
        ];
    }
}
