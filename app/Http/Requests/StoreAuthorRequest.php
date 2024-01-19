<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
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
            'authorName' => 'required|string|max:255|not_regex:/<[a-z][\s\S]*>/i',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'authorName.required' => '著者名は必須です。',
            'authorName.string' => '著者名は文字列である必要があります。',
            'authorName.max' => '著者名は最大255文字までです。',
            'authorName.not_regex' => 'HTMLタグは許可されていません。'
        ];
    }
}
