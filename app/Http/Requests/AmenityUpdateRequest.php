<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AmenityUpdateRequest extends FormRequest
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
        $amenityId = $this->route('amenity');
        
        // If it's a model instance, get the ID
        if (is_object($amenityId) && method_exists($amenityId, 'getKey')) {
            $amenityId = $amenityId->getKey();
        }
        
        // If it's not found in the route, try to get it from the request
        if (!$amenityId) {
            $amenityId = $this->input('id') ?? $this->route('id');
        }

        return [
            'name' => 'required|string|max:255|unique:amenities,name,' . $amenityId,
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
