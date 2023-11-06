<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GreetingCompanyRequest extends FormRequest
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
            'message_company' => 'required|max:500|min:2',
            'celebrant' => ['numeric', 'celebrant_id' => 'exists:celebrants,id'],
            'company' => ['numeric', 'company_id' => 'exists:companies,id'],
        ];
    }
}
