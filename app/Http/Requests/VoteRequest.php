<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoteRequest extends FormRequest
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
            'celebrant' => ['numeric', 'celebrant_id' => 'exists:celebrants,id'],
            'selected_gifts' => 'required|array',
            'selected_gifts.*' => 'exists:gifts,id',
        ];
    }
}
