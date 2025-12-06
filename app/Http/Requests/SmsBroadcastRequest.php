<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SmsBroadcastRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['admin', 'pastor', 'staff']);
    }

    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:1600'], // Max 10 SMS segments
            'recipient_type' => ['required', Rule::in([
                'all_members', 'active_members', 'staff', 'custom_group',
                'service_unit', 'shepherd_group', 'birthday_celebrants',
                'specific_members'
            ])],
            'recipient_ids' => ['nullable', 'array'],
            'recipient_ids.*' => ['exists:members,id'],
            'service_unit_id' => ['nullable', 'required_if:recipient_type,service_unit', 'exists:service_units,id'],
            'shepherd_id' => ['nullable', 'required_if:recipient_type,shepherd_group', 'exists:shepherds,id'],
            'schedule_for' => ['nullable', 'date', 'after:now'],
            'send_immediately' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'Message content is required',
            'message.max' => 'Message exceeds maximum length of 1600 characters (10 SMS segments)',
            'recipient_type.required' => 'Please select recipient type',
            'schedule_for.after' => 'Scheduled time must be in the future',
        ];
    }

    /**
     * Estimate SMS count and cost before sending
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $messageLength = mb_strlen($this->message);
            $smsCount = ceil($messageLength / 160);

            if ($smsCount > 10) {
                $validator->errors()->add('message', 'Message is too long. Maximum 10 SMS segments allowed.');
            }

            // Store SMS count for cost estimation
            $this->merge(['estimated_sms_count' => $smsCount]);
        });
    }
}
