<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiftOptionsRequest extends FormRequest
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
            'gifts' => 'required|array',
            'gifts.*.picture' => 'required|url',
            'gifts.*.title' => 'required|max:255',
            'gifts.*.link' => 'required|url',
            'gifts.*.price' => 'numeric|required',
            'celebrant_id' => ['numeric', 'celebrant_id' => 'exists:celebrants,id'],
        ];
    }
}
