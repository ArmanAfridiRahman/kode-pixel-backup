<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TicketSettingRequest extends FormRequest
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
            'ticket_setting.*.labels' => 'required',
            'ticket_setting.*.type' => 'required',
            'ticket_setting.*.required' => 'required',
            'ticket_setting.*.placeholder' => 'required',
            'ticket_setting.*.default' => 'required',
            'ticket_setting.*.multiple' => 'required',
        ];
    }


    public function messages()
    {
         return [ 
            'ticket_setting.*.labels.required' => translate('All Labels Field Is Required'),
            'ticket_setting.*.type.required' => translate('All Type Field Is Required'),
            'ticket_setting.*.required.required' => translate('All Required Field Is Required'),
            'ticket_setting.*.placeholder.required' => translate('All Placeholder Field Is Required'),
            'ticket_setting.*.default.required' => translate('All Default Field Is Required'),
            'ticket_setting.*.multiple.required' => translate('All Multiple Field Is Required'),
         ];
    }
}
