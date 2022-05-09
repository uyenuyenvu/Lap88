<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name'              => "required|min:5|max:255|unique:products,name, $this->id",
//            'quantity'          => 'required|numeric|max:10000|integer',
            'origin_price'      => 'required|numeric|max:100000000|integer',
            'sale_price'        => 'required|numeric|max:100000000|integer',
//            'content'           => 'required',
            'image[]'           => 'image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => ':attribute không được để trống',
            'name.min'                  => 'Nhập ít nhất :min ký tự',
            'name.max'                  => 'Không được nhập quá :max ký tự',
            'name.unique'               => ':attribute đã tồn tại',

//            'quantity.required'         => ':attribute không được để trống',
//            'quantity.numeric'          => ':attribute phải nhập số',
//            'quantity.max'              => ':attribute không nhập quá :max',
//            'quantity.integer'          => ':attribute phải là số nguyên',

            'origin_price.required'     => ':attribute không được để trống',
            'origin_price.numeric'      => ':attribute phải nhập số',
            'origin_price.max'          => ':attribute không nhập quá :max',
            'origin_price.integer'      => ':attribute phải là số nguyên',

            'sale_price.required'       => ':attribute không được để trống',
            'sale_price.numeric'        => ':attribute phải nhập số',
            'sale_price.max'            => ':attribute không nhập quá :max',
            'sale_price.integer'        => ':attribute phải là số nguyên',

//            'content.required'          => ':attribute không được để trống',

            'image[].mimes'             => 'Chỉ hỗ trợ định dạng: jpeg, jpg, png',
            'image[].max'               => ':attribute vượt quá dung lượng (max: :max kb)',
        ];
    }

    public function attributes()
    {
        return [
            'name'              => 'Tên sản phẩm',
//            'quantity'          => 'Số lượng sản phẩm',
            'origin_price'      => 'Giá gốc',
            'sale_price'        => 'Giá bán',
//            'content'           => 'Nội dung',
            'image[]'           => 'hình ảnh'
        ];
    }
}
