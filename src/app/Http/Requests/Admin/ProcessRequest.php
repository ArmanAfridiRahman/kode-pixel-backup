<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;

class ProcessRequest extends FormRequest
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
            'short_description' => 'max:100',
            'icon'=>'required|max:150',
            'status' => [Rule::in(StatusEnum::toArray())],
            
        ];

        if(request()->routeIs('admin.process.update')){
             $rules ['id'] = "required|exists:processes,id";
        }
        return $rules;
    }
}
