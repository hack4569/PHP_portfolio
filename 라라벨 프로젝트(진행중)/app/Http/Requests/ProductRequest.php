<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'eng_name' => 'required',
            'kor_name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute (는)은 필수 입력 항목입니다.'
        ];
    }

    public function attributes()
    {
        return [
            'eng_name' => '영문명',
            'kor_name' => '한글명'
        ];
    }
}
