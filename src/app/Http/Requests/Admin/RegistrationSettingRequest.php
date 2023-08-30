<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationSettingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'registration.*.labels' => 'required',
            'registration.*.order' => 'required',
            'registration.*.width' => 'required',
            'registration.*.status' => 'required',
            'registration.*.type' => 'required',
            'registration.*.required' => 'required',
            'registration.*.placeholder' => 'required',
            'registration.*.default' => 'required',
            'registration.*.multiple' => 'required',
        ];
    }


    public function messages()
    {
         return [ 
            'registration.*.labels.required' => translate('All Labels Field Is Required'),
            'registration.*.type.required' => translate('All Type Field Is Required'),
            'registration.*.required.required' => translate('All Required Field Is Required'),
            'registration.*.placeholder.required' => translate('All Placeholder Field Is Required'),
            'registration.*.default.required' => translate('All Default Field Is Required'),
            'registration.*.multiple.required' => translate('All Multiple Field Is Required'),
         ];
    }
}
