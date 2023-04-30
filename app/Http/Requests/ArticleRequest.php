<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title'=> ['required', 'max:2000'],
            'image'=> ['nullable', 'image'],
            'content'=> ['nullable', 'string', 'required'],
            'hidden'=> ['boolean'],
            'category_id'=>['required']
        ];
    }
}
