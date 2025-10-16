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
        // Get the land type ID from the route
        $landTypeId = $this->route('landType');
        
        // If it's a model instance, get the ID
        if (is_object($landTypeId) && method_exists($landTypeId, 'getKey')) {
            $landTypeId = $landTypeId->getKey();
        }
        
        // If it's not found in the route, try to get it from the request
        if (!$landTypeId) {
            $landTypeId = $this->input('id') ?? $this->route('id');
        }

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