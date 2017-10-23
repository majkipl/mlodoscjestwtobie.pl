<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string|max:255|unique:products,name',
            'category_id' => 'required|integer|exists:categories,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'required' => 'Pole jest wymagane.',
            'string' => 'Wprowadź wartość tekstową.',
            'max' => 'Pole wymaga maksymalnie :max znaków.',
            'unique' => 'Taki wpis już istnieje.',
            'integer' => 'Błędny format danych.',
            'exists' => 'Rekord nie istnieje',
        ];
    }
}
