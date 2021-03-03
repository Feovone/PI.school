<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActionRequest extends FormRequest
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
    public function rules($type)
    {
       switch ($type){
           case 'income':
            return [
                'action' => 'required',
                'currency' => 'required',
                'sum' => 'required|numeric',
                'date' => 'required|date',
                'forceDate' => 'nullable|date',
                'forceRate' => 'nullable|numeric',
            ];
           case 'exchange':
            return [
                'action' => 'required',
                'currency' => 'required',
                'sum' => 'required|numeric',
                'rate' => 'required|numeric',
                'date' => 'required|date',
            ];
        }


    }
}
