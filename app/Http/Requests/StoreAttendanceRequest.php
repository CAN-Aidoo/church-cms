<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['admin', 'pastor', 'staff']);
    }

    public function rules(): array
    {
        return [
            'member_id' => ['required', 'exists:members,id'],
            'service_date' => ['required', 'date'],
            'service_type' => ['required', Rule::in([
                'sunday_first', 'sunday_second', 'sunday_third',
                'midweek', 'prayer', 'youth', 'children', 'special',
            ])],
            'attendance_status' => ['required', Rule::in(['present', 'absent', 'excused', 'late', 'online'])],
            'notes' => ['nullable', 'string', 'max:500'],
            'checked_in_at' => ['nullable', 'date'],
            'checked_in_by' => ['nullable', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'member_id.required' => 'Member selection is required',
            'member_id.exists' => 'Selected member does not exist',
            'service_date.required' => 'Service date is required',
            'service_type.required' => 'Service type is required',
        ];
    }
}
