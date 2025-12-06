<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['admin', 'pastor', 'staff']);
    }

    public function rules(): array
    {
        return [
            'service_date' => ['required', 'date'],
            'service_type' => ['required', Rule::in([
                'sunday_first', 'sunday_second', 'sunday_third',
                'midweek', 'prayer', 'youth', 'children', 'special'
            ])],
            'attendance' => ['required', 'array', 'min:1'],
            'attendance.*.member_id' => ['required', 'exists:members,id'],
            'attendance.*.status' => ['required', Rule::in(['present', 'absent', 'excused', 'late', 'online'])],
            'attendance.*.notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'attendance.required' => 'At least one attendance record is required',
            'attendance.*.member_id.exists' => 'One or more selected members do not exist',
        ];
    }
}
