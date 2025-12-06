<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['admin', 'pastor', 'staff']);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'program_type' => ['required', Rule::in([
                'conference', 'seminar', 'retreat', 'crusade', 'workshop',
                'training', 'outreach', 'social', 'fundraising', 'other'
            ])],
            'category' => ['nullable', Rule::in([
                'spiritual_development', 'leadership_training', 'youth',
                'marriage_enrichment', 'professional_development', 'evangelism', 'other'
            ])],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'venue' => ['required', 'string', 'max:255'],
            'venue_address' => ['nullable', 'string', 'max:500'],
            'capacity' => ['nullable', 'integer', 'min:1', 'max:100000'],
            'registration_required' => ['required', 'boolean'],
            'registration_fee' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'registration_deadline' => ['nullable', 'required_if:registration_required,true', 'date', 'before:start_date'],
            'target_audience' => ['nullable', 'string', 'max:255'],
            'organizer_name' => ['nullable', 'string', 'max:255'],
            'organizer_phone' => ['nullable', 'string', 'regex:/^[+]?[0-9]{10,15}$/'],
            'flyer' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Program name is required',
            'start_date.after_or_equal' => 'Start date cannot be in the past',
            'end_date.after_or_equal' => 'End date must be on or after start date',
            'registration_deadline.before' => 'Registration deadline must be before program start date',
        ];
    }
}
