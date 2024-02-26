<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'lastname' => 'required|max:100|min:2|regex:/^[а-яґїієa-z\-\'\s]+$/ui',
            'name' => 'required|max:100|min:2|regex:/^[а-яґїієa-z\-\'\s]+$/ui',
            'middlename' => 'nullable|max:100|min:2|regex:/^[а-яґїієa-z\-\'\s]+$/ui',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user)],
            'company' => ['numeric', 'company_id' => 'exists:companies,id'],
            'photoFile' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ];
    }
}
