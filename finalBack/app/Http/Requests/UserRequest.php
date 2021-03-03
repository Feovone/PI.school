<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'firstName' => 'alpha|min:4|nullable',
            'lastName' => 'alpha|min:4|nullable',
            'forcePercentage' => 'numeric|between:1,100|nullable',
            'exchangeFlag' => 'boolean|nullable',
            'taxRate' => 'numeric|nullable',
            'notification' => 'alpha|nullable',
        ];
    }
}
