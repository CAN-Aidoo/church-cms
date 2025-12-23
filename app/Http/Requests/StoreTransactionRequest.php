<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['admin', 'pastor', 'staff']);
    }

    public function rules(): array
    {
        return [
            'transaction_type' => ['required', Rule::in(['income', 'expense'])],
            'category' => ['required', 'string', 'max:100'],
            'subcategory' => ['nullable', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:99999999.99'],
            'description' => ['required', 'string', 'max:500'],
            'transaction_date' => ['required', 'date', 'before_or_equal:today'],
            'payment_method' => ['required', Rule::in([
                'cash', 'cheque', 'bank_transfer', 'mobile_money',
                'card', 'online', 'other',
            ])],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'member_id' => ['nullable', 'exists:members,id'],
            'department' => ['nullable', 'string', 'max:100'],
            'project_id' => ['nullable', 'exists:programs,id'],
            'receipt' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // 5MB
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Transaction amount is required',
            'amount.min' => 'Amount must be greater than zero',
            'amount.max' => 'Amount exceeds maximum allowed value',
            'transaction_date.before_or_equal' => 'Transaction date cannot be in the future',
            'receipt.max' => 'Receipt file size must not exceed 5MB',
        ];
    }

    /**
     * Configure validator instance for conditional validation
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // If expense, ensure category is valid expense category
            if ($this->transaction_type === 'expense') {
                $validExpenseCategories = [
                    'salaries', 'utilities', 'maintenance', 'events',
                    'admin', 'welfare', 'missions', 'equipment', 'other',
                ];
                if (! in_array($this->category, $validExpenseCategories)) {
                    $validator->errors()->add('category', 'Invalid expense category');
                }
            }

            // If income, ensure category is valid income category
            if ($this->transaction_type === 'income') {
                $validIncomeCategories = [
                    'tithe', 'offering', 'donation', 'pledge',
                    'partnership', 'fundraising', 'rent', 'other',
                ];
                if (! in_array($this->category, $validIncomeCategories)) {
                    $validator->errors()->add('category', 'Invalid income category');
                }
            }
        });
    }
}
