<?php

namespace Laravel\VaporUi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the log request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'query' => ['nullable', 'string'],
            'startTime' => ['required', 'integer'],
            'cursor' => ['nullable', 'string'],
            'type' => ['nullable', 'string'],
        ];
    }
}
