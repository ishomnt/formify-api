<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as FormRequestHttp;

class FormRequest extends FormRequestHttp
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'slug' => ['required','string', 'unique:forms,slug', 'alpha_dash'],
            'allowed_domains' => ['array']
        ];
    }
}
