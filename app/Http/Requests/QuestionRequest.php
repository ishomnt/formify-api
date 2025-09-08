<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'choice_type' => ['required', 'in:short answer,paragraph,date,multiple choice,dropdown,checkboxes'],
            'choices' => ['array', 'required_if:choice_type,multiple choice,dropdown,checkboxes'],
            'choices.*' => ['string']
        ];
    }
}
