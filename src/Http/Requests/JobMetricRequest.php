<?php

namespace Laravel\VaporUi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobMetricRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the job metric request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'queue' => ['string'],
        ];
    }
}
