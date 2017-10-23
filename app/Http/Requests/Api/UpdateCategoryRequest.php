<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'bail|required|string|max:128',
            'id' => 'required|integer|exists:categories,id'
        ];

        if ($this->input('slug') !== null) {
            $rules['slug'] = 'bail|string|max:128';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Pole jest wymagane.',
            'name.string' => 'Wprowadź wartość tekstową.',
            'name.max' => 'Pole wymaga maksymalnie :max znaków.',

            'id.required' => 'Pole jest wymagane',
            'id.integer' => 'Wprowadź prawidłową wartość',
            'id.exists' => 'Rekord nie istnieje',

            'slug.string' => 'Wprowadź wartość tekstową.',
            'slug.max' => 'Pole wymaga maksymalnie :max znaków.',
        ];
    }
}
