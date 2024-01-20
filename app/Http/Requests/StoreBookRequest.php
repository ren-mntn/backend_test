<?php

namespace App\Http\Requests;

class StoreBookRequest extends BaseBookRequest
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
        $rules['isbn'][] = 'unique:books,isbn';
        return $rules;
    }
}
