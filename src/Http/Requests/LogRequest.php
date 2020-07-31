<?php

namespace Laravel\VaporUi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

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
            'group' => [Rule::in(['http', 'cli', 'queue'])],
            'query' => ['nullable', 'string'],
            'limit' => ['nullable', 'integer', 'min:0', 'max:100'],
            'startTime' => ['nullable', 'integer'],
            'endTime' => ['nullable', 'integer'],
            'cursor' => ['nullable', 'string'],
        ];
    }

    /**
     * Gets the timestamp from the given input name, if any.
     *
     * @param  string $key
     * 
     * @return int|null
     */
    public function validated()
    {
        $validated = parent::validated();

        $validated['startTime'] = $this->input(
            'startTime',
            Carbon::now()
                ->second(0)
                ->subHours(1)
                ->timestamp * 1000
        );

        return $validated;
    }
}
