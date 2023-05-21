<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string', 'min:5'],
            'description' => ['required','string', 'min:5'],
            'level' => ['required', 'string'],
            'begin_at' => ['date', 'required', 'after:date'],
            'finish_at' => ['date', 'required', 'after:begin_at'],
            'beginned_at' => ['date', 'nullable'],
            'finished_at' => ['date', 'nullable'],
            'notifiable' => ['required', 'boolean'],
            'group_id' => ['exists:groups,id', 'nullable'],
        ];
    }
}
