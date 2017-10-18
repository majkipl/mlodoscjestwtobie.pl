<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AddCategoryRequest extends FormRequest
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
        $rules = [
            'name' => 'bail|required|string|max:128',
        ];

        if ($this->input('slug') !== null) {
            $rules['slug'] = 'bail|string|max:128|unique:categories,slug';
        }

        return $rules;
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'required' => 'Pole jest wymagane.',
            'string' => 'Wprowadź wartość tekstową.',
            'max' => 'Pole wymaga maksymalnie :max znaków.',
            'slug.unique' => 'Slug jest już zajęty.',
        ];
    }
}
