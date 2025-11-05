<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegularUserUpdateRequest extends FormRequest
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
        $userId = $this->route('regular_user');

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$userId,
            'password' => 'nullable|string|min:8',
            'contact' => 'nullable|string|max:255|regex:/^[0-9]+$/',
            'dob' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.min' => 'The password must be at least 8 characters.',
            'contact.regex' => 'The contact number may only contain numbers.',
            'status.required' => 'The status field is required.',
            'photo.image' => 'The photo must be an image file.',
            'photo.max' => 'The photo may not be greater than 2MB.',
        ];
    }
}