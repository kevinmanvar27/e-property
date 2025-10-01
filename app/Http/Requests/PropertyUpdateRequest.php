<?php

namespace App\Http\Requests;

class PropertyUpdateRequest extends BasePropertyRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = parent::rules();
        
        // Make documents nullable for updates
        $rules['document_7_12'] = 'nullable|file|mimes:pdf,jpg,png|max:102400'; // 100MB
        $rules['document_8a'] = 'nullable|file|mimes:pdf,jpg,png|max:102400'; // 100MB
        
        // Always allow photos
        $rules['photos'] = 'nullable|array';
        $rules['photos.*'] = 'file|mimes:jpg,jpeg,png|max:102400'; // 100MB
        
        return $rules;
    }
}