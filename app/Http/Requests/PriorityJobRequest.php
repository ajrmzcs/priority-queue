<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PriorityJobRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'submitter_id'  => 'required|integer',
            'priority'      => [
                'required',
                Rule::in(
                    [
                        'high',
                        'low',
                    ]
                ),
            ],
            'command'   => [
                'required',
                Rule::in(
                    [
                        'command_1',
                        'command_2',
                    ]
                ),
            ]
        ];
    }
}
