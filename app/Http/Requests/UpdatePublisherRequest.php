<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePublisherRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|not_regex:/<[a-z][\s\S]*>/i',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => '出版社名は必須です。',
            'name.string' => '出版社名は文字列である必要があります。',
            'name.max' => '出版社名は最大255文字までです。',
            'name.not_regex' => 'HTMLタグは許可されていません。'
        ];
    }
}
