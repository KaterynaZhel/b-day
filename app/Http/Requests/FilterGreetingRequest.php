<?php

namespace App\Http\Requests;

use App\Casts\CelebrantPosition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterGreetingRequest extends FormRequest
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
            'nameFriend' => 'nullable|string',
            'publicationDateFrom' => 'nullable|date_format:Y-m-d',
            'publicationDateTo' => 'nullable|date_format:Y-m-d',

        ];
    }
}