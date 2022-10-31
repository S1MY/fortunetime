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
            'user_id' => ['required', 'string', 'min:1'],
            'review' => ['required', 'string', 'max:255', 'min:10'],
        ];
    }

    public function messages()
    {
        return[
            'user_id.required' => 'Для написания отзыва необходимо авторизироваться.',
            'required' => 'Нельзя оставить пустой отзыв.',
            'string' => 'Неподходящий формат отзыва.',
            'min' => 'Минимальное количество символов в отзыве 10.',
            'max' => 'Максимальное количество символов в отзыве 255.',
        ];
    }

}
