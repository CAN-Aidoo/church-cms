<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $member = $this->route('member');
        return $this->user()->can('update', $member);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $memberId = $this->route('member')->id;

        return [
            // Basic Information
            'first_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'marital_status' => ['required', Rule::in(['single', 'married', 'divorced', 'widowed'])],

            // Contact Information
            'email' => ['nullable', 'email', 'max:255', Rule::unique('members')->ignore($memberId)],
            'phone' => ['nullable', 'string', 'regex:/^[+]?[0-9]{10,15}$/', Rule::unique('members')->ignore($memberId)],
            'whatsapp' => ['nullable', 'string', 'regex:/^[+]?[0-9]{10,15}$/'],
            'address' => ['nullable', 'string', 'max:500'],
            'gps_location' => ['nullable', 'string', 'max:255'],

            // Personal Details
            'occupation' => ['nullable', 'string', 'max:255'],
            'workplace' => ['nullable', 'string', 'max:255'],
            'education_level' => ['nullable', Rule::in(['none', 'primary', 'jhs', 'shs', 'tertiary', 'postgraduate'])],
            'blood_group' => ['nullable', Rule::in(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])],
            'allergies' => ['nullable', 'string', 'max:1000'],
            'medical_conditions' => ['nullable', 'string', 'max:1000'],

            // Church Information
            'membership_date' => ['required', 'date', 'before_or_equal:today'],
            'baptism_status' => ['required', Rule::in(['not_baptized', 'baptized', 'baptized_elsewhere'])],
            'baptism_date' => ['nullable', 'required_if:baptism_status,baptized', 'date', 'before_or_equal:today'],
            'holy_spirit_baptism' => ['required', 'boolean'],
            'holy_spirit_baptism_date' => ['nullable', 'required_if:holy_spirit_baptism,true', 'date', 'before_or_equal:today'],
            'shepherd_id' => ['nullable', 'exists:shepherds,id'],

            // Emergency Contact
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'regex:/^[+]?[0-9]{10,15}$/'],
            'emergency_contact_relationship' => ['nullable', 'string', 'max:100'],

            // Family Information
            'family_id' => ['nullable', 'exists:families,id'],
            'spouse_name' => ['nullable', 'required_if:marital_status,married', 'string', 'max:255'],
            'spouse_is_member' => ['nullable', 'boolean'],
            'spouse_member_id' => ['nullable', 'exists:members,id'],

            // Profile Photo
            'photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],

            // Status
            'status' => ['required', Rule::in(['pending', 'active', 'inactive', 'suspended', 'transferred'])],
            'status_reason' => ['nullable', 'required_unless:status,active', 'string', 'max:500'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.unique' => 'This email address is already registered',
            'phone.unique' => 'This phone number is already registered',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Ensure at least phone or email is provided
            if (empty($this->phone) && empty($this->email)) {
                $validator->errors()->add('contact', 'Either phone number or email address is required');
            }
        });
    }
}
