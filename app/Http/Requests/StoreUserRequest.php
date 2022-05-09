<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'          => 'required|min:5|max:50',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'required|digits_between:10,11|unique:users,phone|regex:/(0)[0-9]{9}/',
            'address'       => 'required|min:5|max:100',
            'password'      => 'required|min:8|max:32'
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => ':attribute không được để trống',
            'name.min'              => ':attribute phải lớn hơn :min ký tự',
            'name.max'              => ':attribute phải nhỏ hơn :max ký tự',
//            'name.alpha'            => ':attribute chỉ được phép chứa chữ',

            'email.required'        => ':attribute không được để trống',
            'email.email'           => ':attribute không hợp lệ',
            'email.unique'          => ':attribute đã tồn tại',

            'phone.required'        => ':attribute không được để trống',
            'phone.digits_between'  => ':attribute chỉ chứa số và có độ dài 10 hoặc 11 ký tự',
            'phone.unique'          => ':attribute đã tồn tại',
            'phone.regex'           => ':attribute không hợp lệ',

            'address.required'      => ':attribute không được để trống',
            'address.min'           => ':attribute phải lớn hơn :min ký tự',
            'address.max'           => ':attribute phải nhỏ hơn :max ký tự',

            'password.required'     => ':attribute không được để trống',
            'password.min'          => ':attribute phải lớn hơn :min ký tự',
            'password.max'          => ':attribute phải nhỏ hơn :max ký tự',
            'password.regex'        => ':attribute phải chứa ký tự thường, ký tự in hoa, số và ký tự đặc biệt',
        ];
    }

    public function attributes()
    {
        return [
            'name'          => 'Họ tên',
            'email'         => 'Email',
            'phone'         => 'Số điện thoại',
            'address'       => 'Địa chỉ',
            'password'      => 'Mật khẩu'
        ];
    }
}
