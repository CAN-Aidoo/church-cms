<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCounsellingSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['admin', 'pastor']);
    }

    public function rules(): array
    {
        return [
            'member_id' => ['required', 'exists:members,id'],
            'counsellor_id' => ['required', 'exists:counsellors,id'],
            'case_id' => ['nullable', 'exists:counselling_cases,id'],
            'session_type' => ['required', Rule::in([
                'pre_marital', 'marital', 'youth', 'addiction',
                'grief', 'career', 'spiritual', 'family', 'other',
            ])],
            'session_date' => ['required', 'date', 'after_or_equal:today'],
            'session_time' => ['required', 'date_format:H:i'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:240'],
            'location' => ['nullable', 'string', 'max:255'],
            'mode' => ['required', Rule::in(['in_person', 'phone', 'video', 'online'])],
            'notes' => ['nullable', 'string', 'max:5000'],
            'issue_summary' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'member_id.required' => 'Please select a member',
            'counsellor_id.required' => 'Please assign a counsellor',
            'session_date.after_or_equal' => 'Session date cannot be in the past',
            'duration_minutes.min' => 'Session duration must be at least 15 minutes',
            'duration_minutes.max' => 'Session duration cannot exceed 4 hours',
        ];
    }
}
