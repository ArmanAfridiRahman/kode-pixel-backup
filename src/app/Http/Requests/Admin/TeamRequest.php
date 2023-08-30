<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;

class TeamRequest extends FormRequest
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
            'name' => 'required|unique:teams,name,'.request()->id,
            'designation' => 'required|max:25',
            'status' => [Rule::in(StatusEnum::toArray())],
            
        ];

        if(request()->routeIs('admin.team.update')){
            $rules['id']= "required|exists:teams,id";
        }
        return $rules;
    }
}
