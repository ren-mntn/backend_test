<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseBookRequest extends FormRequest
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
    public function commonRules()
    {
        return  [
            'isbn' => [
                'required',
                'string',
                'regex:/^(97(8|9))?\d{9}(\d|X)$/i',
                // 'unique' のルールは各サブクラスで定義する
            ],
            'book_name' => 'required|string|max:255',
            'published_at' => 'required|date|date_format:Y-m-d',
            'author_id' => 'required|integer|exists:authors,id',
            'publisher_id' => 'required|integer|exists:publishers,id',
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
            'isbn.regex' => 'ISBNは13桁である必要があります。',
            'isbn.unique' => 'このISBNは既に使用されています。別のISBNを指定してください。',
            'name.required' => '書籍名は必須です。',
            'name.string' => '書籍名は文字列である必要があります。',
            'name.max' => '書籍名は最大255文字までです。',
            'published_at.required' => '出版日は必須です。',
            'published_at.date' => '出版日は有効な日付形式である必要があります。',
            'published_at.date_format' => '出版日は "Y-m-d" 形式に一致する必要があります。',
            'author_id.required' => '著者IDは必須です。',
            'author_id.integer' => '著者IDは整数である必要があります。',
            'author_id.exists' => '指定された著者IDは存在しません。',
            'publisher_id.required' => '出版社IDは必須です。',
            'publisher_id.integer' => '出版社IDは整数である必要があります。',
            'publisher_id.exists' => '指定された出版社IDは存在しません。',
        ];
    }
}
