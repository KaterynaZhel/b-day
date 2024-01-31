<?php

namespace App\Http\Requests;

use App\Casts\CelebrantPosition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterCelebrantRequest extends FormRequest
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
            'lastname' => 'nullable|string',
            'firstname' => 'nullable|string',
            'birthday' => 'nullable|date_format:Y-m-d',
            'birthdayFrom' => 'nullable|date_format:Y-m-d',
            'birthdayTo' => 'nullable|date_format:Y-m-d',
            'monthFrom' => 'nullable|date_format:m',
            'monthTo' => 'nullable|date_format:m',
            'dayFrom' => 'nullable|date_format:d',
            'dayTo' => 'nullable|date_format:d',
            'position' => ['nullable', Rule::in(CelebrantPosition::$positions)],
            'nearestBirthdays' => 'nullable|numeric',
            'birthdayRange' => 'nullable|string',
            'name' => 'nullable|string',

        ];
    }
}
