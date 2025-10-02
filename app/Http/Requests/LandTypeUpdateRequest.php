<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LandTypeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $landTypeId = $this->route('landType');

        return [
            'name' => 'required|string|max:255|unique:land_types,name,' . $landTypeId,
            'description' => 'nullable|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            //
        ];
    }
}
