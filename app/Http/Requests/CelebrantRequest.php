<?php

namespace App\Http\Requests;

use App\Casts\CelebrantPosition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CelebrantRequest extends FormRequest
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
            'firstname' => 'required|max:100|min:2|regex:/^[а-яґїієa-z\-\'\s]+$/ui',
            'middlename' => 'nullable|max:100|min:2|regex:/^[а-яґїієa-z\-\'\s]+$/ui',
            'birthday' => 'required|date_format:Y-m-d',
            'email' => 'required|email|unique:celebrants',
            'company' => ['numeric', 'company_id' => 'exists:companies,id'],
            'position' => ['nullable', Rule::in(CelebrantPosition::$positions)],
            'hobbies' => 'nullable|array',
            'hobbies.*' => 'string',
            'photoFile' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ];
    }
}