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
            'start_at' => 'date_format:Y-m-d H:i:s',
            'end_at' => 'date_format:Y-m-d H:i:s',
            'celebrant' => ['numeric', 'celebrant_id' => 'exists:celebrants,id'],
            'gift' => ['numeric', 'gift_id' => 'exists:gifts,id'],
        ];
    }
}
