<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationEntityStoreRequest extends FormRequest
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
        $rules = [
            'entity_type' => 'required|string|in:state,district,city',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];

        $entityType = $this->input('entity_type');

        switch ($entityType) {
            case 'state':
                $rules['name'] = 'required|string|max:255|unique:state,state_title';
                $rules['country_id'] = 'required|exists:countries,country_id';

                break;

            case 'district':
                $rules['name'] = 'required|string|max:255|unique:district,district_title';
                $rules['state_id'] = 'required|exists:state,state_id';

                break;

            case 'city':
                $rules['name'] = 'required|string|max:255|unique:city,name';
                $rules['districtid'] = 'required|exists:district,districtid';
                $rules['state_id'] = 'required|exists:state,state_id';

                break;
        }

        return $rules;
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
