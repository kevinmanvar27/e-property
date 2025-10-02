<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BasePropertyRequest extends FormRequest
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
        return [
            'owner_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'size' => 'nullable|numeric|min:0',
            'apartment_name' => 'nullable|string|max:255',
            'bhk' => 'nullable|integer|min:0',
            'is_apartment' => 'nullable|string|in:yes,no',
            'apartment_floor' => 'nullable|integer|min:0',
            'is_tenament' => 'nullable|string|in:yes,no',
            'tenament_floors' => 'nullable|integer|min:0',
            'first_line' => 'required|string|max:255',
            'second_line' => 'nullable|string|max:255',
            'village' => 'required|string|max:255',
            'taluka_id' => 'nullable|exists:city,id',
            'district_id' => 'required|exists:district,districtid',
            'state_id' => 'required|exists:state,state_id',
            'pincode' => 'required|string|max:10',
            'country_id' => 'required|exists:countries,country_id',
            'property_type' => 'required|string|in:land_jamin,plot,shad,shop,house',
            'status' => 'nullable|string|in:active,inactive,urgent,under_offer,reserved,sold,cancelled,coming_soon,price_reduced',
            'vavetar' => 'nullable|in:Yes,No',
            'any_issue' => 'nullable|in:Yes,No',
            'issue_description' => 'nullable|string|max:500',
            'electric_poll' => 'nullable|in:Yes,No',
            'electric_poll_count' => 'nullable|integer|min:1',
            'family_issue' => 'nullable|in:Yes,No',
            'family_issue_description' => 'nullable|string|max:500',
            'road_distance' => 'nullable|numeric|min:0|max:999999.99',
            'additional_notes' => 'nullable|string',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'land_types' => 'nullable|array',
            'land_types.*' => 'exists:land_types,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'owner_name.required' => 'The owner name field is required.',
            'district_id.required' => 'The district field is required.',
            'state_id.required' => 'The state field is required.',
            'country_id.required' => 'The country field is required.',
            'property_type.required' => 'The property type field is required.',
            'district_id.exists' => 'The selected district is invalid.',
            'state_id.exists' => 'The selected state is invalid.',
            'country_id.exists' => 'The selected country is invalid.',
        ];
    }
}
