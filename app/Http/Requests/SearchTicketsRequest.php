<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchTicketsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['numeric', 'nullable'],
            'client' =>['string', 'nullable'],
            'assigned' =>['string', 'nullable'],
            'status' =>['string', 'nullable'],
            'begin' =>['date', 'nullable'],
            'end' =>['date', 'nullable']
        ];
    }
}
