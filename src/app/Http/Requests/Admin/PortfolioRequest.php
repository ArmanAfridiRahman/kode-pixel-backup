<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;

class PortfolioRequest extends FormRequest
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
            'title' => 'required|unique:portfolios,title,'.request()->id,
            'short_description' => 'max:100',
            'url' => 'required',
            'status' => [Rule::in(StatusEnum::toArray())],
            
        ];

        if(request()->routeIs('admin.portfolio.update')){
            $rules['id']= "required|exists:portfolios,id";
        }
        return $rules;
    }
}
