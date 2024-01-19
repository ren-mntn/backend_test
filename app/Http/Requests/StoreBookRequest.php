<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'isbn' => 'required|string|isbn13',
            'name' => 'required|string|max:255',
            'publishedAt' => 'required|date|date_format:Y-m-d\TH:i:s.u',
            // 'author' =>
            // 'publisher' =>
            // TODO リクエストデータの詳細の回答まち
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'isbn.required' => 'ISBNは必須です。',
            'isbn.string' => 'ISBNは文字列である必要があります。',
            'isbn.isbn13' => 'ISBNは13桁である必要があります。',
            'name.required' => '書籍名は必須です。',
            'name.string' => '書籍名は文字列である必要があります。',
            'name.max' => '書籍名は最大255文字までです。',
            'publishedAt.required' => '出版日は必須です。',
            'publishedAt.date' => '出版日は有効な日付形式である必要があります。',
            'publishedAt.date_format' => '出版日は "Y-m-d\TH:i:s.u" 形式に一致する必要があります。',
        ];
    }
}
