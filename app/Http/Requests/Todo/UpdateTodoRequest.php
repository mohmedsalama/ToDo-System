<?php

namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoRequest extends FormRequest
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
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'due_date' => ['nullable', 'date', 'after_or_equal:today'],
            'is_completed' => ['sometimes', 'boolean'],
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
            'title.required' => 'A title must be provided if you are attempting to update it.',
            'title.max' => 'The title cannot exceed 255 characters.',
            'description.max' => 'Please keep the description under 1000 characters.',
            'due_date.date' => 'The due date must be a valid date format.',
            'due_date.after_or_equal' => 'The due date cannot be moved to a past date.',
            'is_completed.boolean' => 'The completed status must be either true or false.',
        ];
    }
}
