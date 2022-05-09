<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrademarkRequest extends FormRequest
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
            'name' => "required|max:255|unique:trademarks,name, $this->id",
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => ':attribute không được để trống',
            'name.max'          => ':attribute không quá :max ký tự',
            'name.unique'       => ':attribute đã tồn tại',
        ];
    }

    public function attributes()
    {
        return [
            'name'  => 'Tên thương hiệu'
        ];
    }
}
