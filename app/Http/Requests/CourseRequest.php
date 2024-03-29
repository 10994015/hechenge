<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'content'=> ['string', 'required'],
            'hidden'=> ['boolean'],
            'focus'=>['boolean'],
            'grade'=>['integer', 'required'],
            'watched'=>['nullable'],
            'visitor'=>['nullable'],
            'is_full'=>['boolean'],
            'tags'=>['nullable'],
            'category_id'=>['nullable']
        ];
    }
}
