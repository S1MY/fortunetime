<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
            'pincode' => ['required', 'string', 'min:4', 'max:8'],
        ];
    }
    public function messages()
    {
        return[
            'pincode.required' => 'Пин-код обязателен к заполнению.',
            'pincode.min' => 'Пин-код должен содержать минимум 4 символа.',
            'pincode.max' => 'Пин-код должен содержать максимум 8 символов.',
        ];
    }
}
