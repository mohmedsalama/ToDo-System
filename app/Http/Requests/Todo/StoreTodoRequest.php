<?php

namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;

class StoreTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // We return true because ownership authorization is safely handled in the TodoService.
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'due_date' => ['nullable', 'date', 'after_or_equal:today'],
            'is_completed' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The todo title is absolutely required.',
            'title.max' => 'The title cannot exceed 255 characters.',
            'description.max' => 'Please keep the description under 1000 characters.',
            'due_date.date' => 'The due date must be a valid date.',
            'due_date.after_or_equal' => 'You cannot set a due date in the past. It must be today or later.',
            'is_completed.boolean' => 'The completed status must be either true or false.',
        ];
    }
}
