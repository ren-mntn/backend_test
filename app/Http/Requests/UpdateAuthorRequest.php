<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
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
            'author_name' => 'required|string|max:255|not_regex:/<[a-z][\s\S]*>/i',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'author_name.required' => '著者名は必須です。',
            'author_name.string' => '著者名は文字列である必要があります。',
            'author_name.max' => '著者名は最大255文字までです。',
            'author_name.not_regex' => 'HTMLタグは許可されていません。'
        ];
    }
}
