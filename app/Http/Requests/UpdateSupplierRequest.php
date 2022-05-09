<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
            'name'          => "required|min:5|max:50|unique:suppliers,name, $this->id",
            'email'         => "required|email|unique:suppliers,email, $this->id",
            'phone'         => "required|numeric|min:100000000|max:9999999999|unique:suppliers,phone, $this->id",
            'address'       => 'required|min:5|max:100',
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => ':attribute không được để trống',
            'name.min'              => ':attribute phải lớn hơn :min ký tự',
            'name.max'              => ':attribute phải nhỏ hơn :max ký tự',

            'email.required'        => ':attribute không được để trống',
            'email.email'           => ':attribute không hợp lệ',
            'email.unique'          => ':attribute đã tồn tại',

            'phone.required'        => ':attribute không được để trống',
            'phone.numeric'         => ':attribute không hợp lệ',
            'phone.min'             => ':attribute có độ dài không hợp lệ',
            'phone.max'             => ':attribute có độ dài không hợp lệ',

            'address.required'      => ':attribute không được để trống',
            'address.min'           => ':attribute phải lớn hơn :min ký tự',
            'address.max'           => ':attribute phải nhỏ hơn :max ký tự',
        ];
    }

    public function attributes()
    {
        return [
            'name'          => 'Tên nhà cung cấp',
            'email'         => 'Email',
            'phone'         => 'Số điện thoại',
            'address'       => 'Địa chỉ',
        ];
    }
}
