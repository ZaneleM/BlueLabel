<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'surname' => 'required',
            'id_number' => ['required', 'unique:persons', 'regex:/^\d{13}$/'],
            'mobile_number' => 'required',
            'email' => 'required|email|unique:persons',
            'birth_date' => 'required|date',
            'language' => 'required',
            'interests' => 'required|array',
        ];
    }
}
