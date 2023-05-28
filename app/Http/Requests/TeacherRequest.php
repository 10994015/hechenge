<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            'name'=> ['required', 'max:255'],
            'subname'=> ['nullable', 'max:255'],
            'image'=> ['nullable', 'image'],
            'title1'=> ['string','nullable', 'max:255'],
            'content1'=> ['string', 'nullable'],
            'title2'=> ['string','nullable', 'max:255'],
            'content2'=> ['string', 'nullable'],
            'title3'=> ['string','nullable', 'max:255'],
            'content3'=> ['string', 'nullable'],
            'title4'=> ['string','nullable', 'max:255'],
            'content4'=> ['string', 'nullable'],
            'title5'=> ['string','nullable', 'max:255'],
            'content5'=> ['string', 'nullable'],
            'hidden'=> ['boolean'],
            'category_id'=>['nullable']
        ];
    }
}
