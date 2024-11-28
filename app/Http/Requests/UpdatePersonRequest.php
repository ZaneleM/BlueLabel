<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'id_number' => ['required', 'regex:/^\d{13}$/'],
            'mobile_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'birth_date' => 'required|date',
            'language' => 'required',
            'interests' => 'required',
        ];
    }
}
