<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePrayerRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // All authenticated users can submit prayer requests
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'category' => ['required', Rule::in([
                'healing', 'family', 'financial', 'spiritual',
                'career', 'relationships', 'guidance', 'thanksgiving', 'other'
            ])],
            'urgency' => ['required', Rule::in(['urgent', 'normal', 'ongoing'])],
            'is_anonymous' => ['required', 'boolean'],
            'confidentiality_level' => ['required', Rule::in(['public', 'prayer_team', 'pastoral'])],
            'preferred_duration' => ['nullable', 'integer', 'min:1', 'max:365'], // Days
            'group_id' => ['nullable', 'exists:prayer_groups,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Prayer request title is required',
            'description.required' => 'Please describe your prayer request',
            'category.required' => 'Please select a category',
            'urgency.required' => 'Please indicate urgency level',
        ];
    }
}
