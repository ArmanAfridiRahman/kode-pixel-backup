<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;
use App\Rules\General\FileExtentionCheckRule;

class ServiceRequest extends FormRequest
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
        $rules = [
            'title' => 'required|unique:services,title,'.request()->id,
            'service_name.*' => 'max:50',
            'short_description' => 'max:100',
            'long_description' => 'max:250',
            'status' => [Rule::in(StatusEnum::toArray())],
            "image"=> ['required','image', new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true)) ]
            
        ];

        if(request()->routeIs('admin.service.update')){
            $rules['id']= "required|exists:services,id";
        }
        return $rules;
    }
}
