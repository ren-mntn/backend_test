<?php

namespace App\Http\Requests;

class UpdateBookRequest extends BaseBookRequest
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
        $rules = parent::commonRules();
        // 更新時は変更なしかユニークなisbnのみ許可
        $rules['isbn'][] = 'unique:books,isbn,' . $this->isbn . ',isbn';
        return $rules;
    }
}
