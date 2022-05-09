<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name'              => 'required|min:5|max:255|unique:products,name',
//            'quantity'          => 'required|numeric|max:10000|min:1|integer',
            'origin_price'      => 'required|numeric|max:100000000|min:1000|integer|lt:sale_price',
            'sale_price'        => 'required|numeric|max:100000000|min:1000|integer',
//            'content'           => 'required',
//            'image[]'           => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:200000',
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
//            'quantity.min'              => ':attribute không nhỏ hơn :min',
//            'quantity.integer'          => ':attribute phải là số nguyên',

            'origin_price.required'     => ':attribute không được để trống',
            'origin_price.numeric'      => ':attribute phải nhập số',
            'origin_price.max'          => ':attribute không nhập quá :max',
            'origin_price.min'          => ':attribute không nhỏ hơn :min',
            'origin_price.integer'      => ':attribute phải là số nguyên',
            'origin_price.lt'           => ':attribute không được cao hơn hoặc bằng giá bán',

            'sale_price.required'       => ':attribute không được để trống',
            'sale_price.numeric'        => ':attribute phải nhập số',
            'sale_price.max'            => ':attribute không nhập quá :max',
            'sale_price.min'            => ':attribute không nhỏ hơn :min',
            'sale_price.integer'        => ':attribute phải là số nguyên',

//            'content.required'          => ':attribute không được để trống',

//            'image[].required'          => 'Chưa chọn :attribute',
//            'image[].file'              => 'Upload không thành công',
//            'image[].mimes'             => 'Chỉ hỗ trợ định dạng: jpeg,png,jpg,gif,svg',
//            'image[].max'               => ':attribute vượt quá dung lượng (max: :max kb)',
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
//            'image[]'           => 'hình ảnh'
        ];
    }
}
