<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWelfareCaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['admin', 'pastor']);
    }

    public function rules(): array
    {
        return [
            'member_id' => ['required', 'exists:members,id'],
            'category' => ['required', Rule::in(['medical', 'education', 'housing', 'food', 'emergency', 'other'])],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'amount_requested' => ['required', 'numeric', 'min:1', 'max:999999.99'],
            'supporting_documents' => ['nullable', 'array', 'max:5'],
            'supporting_documents.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'urgency_level' => ['required', Rule::in(['low', 'medium', 'high', 'critical'])],
            'household_size' => ['nullable', 'integer', 'min:1', 'max:50'],
            'monthly_income' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'other_support_sources' => ['nullable', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'member_id.required' => 'Please select a beneficiary',
            'amount_requested.required' => 'Please specify the amount requested',
            'amount_requested.max' => 'Amount exceeds maximum allowed',
            'supporting_documents.max' => 'Maximum 5 supporting documents allowed',
            'supporting_documents.*.max' => 'Each document must not exceed 5MB',
        ];
    }
}
