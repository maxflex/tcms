<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Tag;

class PageStoreRequest extends FormRequest
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
            'seo_text' => 'allow_tags:' . implode(',', Tag::ALLOWED_TAGS)
        ];
    }

    public function messages()
    {
        return [
            'seo_text.allow_tags' => trans('validation.allow_tags')
        ];
    }
}
