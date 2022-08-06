<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2'],
            'email' => ['required', 'email', 'max:255'],
            'question' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return[
            'name.required' => 'Вы не указали ваше имя.',
            'email.required' => 'Вы не указали Email для обратной связи.',
            'question.required' => 'Нельзя оставить пустой вопрос.',
            'string' => 'Неподходящий формат вопроса.',
            'min' => 'Минимальное количество символов 2',
            'question.max' => 'Максимальное количество символов в вопросе 1000.',
        ];
    }
}
