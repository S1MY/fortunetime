<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'question' => ['required', 'string', 'min:1'],
            'answer' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return[
            'question.required' => 'Вы не ввели вопрос',
            'answer.required' => 'Вы забыли указать ответ на вопрос',
        ];
    }

}
