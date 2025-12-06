<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVisitorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['admin', 'pastor', 'staff']);
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'regex:/^[+]?[0-9]{10,15}$/', 'unique:visitors,phone'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'age_range' => ['nullable', Rule::in(['child', 'youth', 'adult', 'senior'])],
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'marital_status' => ['nullable', Rule::in(['single', 'married', 'divorced', 'widowed'])],
            'how_heard' => ['nullable', 'string', 'max:255'],
            'service_attended' => ['nullable', 'string', 'max:100'],
            'prayer_request' => ['nullable', 'string', 'max:1000'],
            'interested_in' => ['nullable', 'array'],
            'interested_in.*' => ['string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'phone.required' => 'Phone number is required',
            'phone.unique' => 'This visitor is already registered',
            'phone.regex' => 'Please provide a valid phone number',
        ];
    }
}
