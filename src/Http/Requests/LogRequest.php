<?php

namespace Laravel\VaporUi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'query' => ['nullable', 'string'],
            'limit' => ['nullable', 'integer', 'min:0', 'max:100'],
            'startTime' => ['required', 'integer'],
            'cursor' => ['nullable', 'string'],
        ];
    }
}
