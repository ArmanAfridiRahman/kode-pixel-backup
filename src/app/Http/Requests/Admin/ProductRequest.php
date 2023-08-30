<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;
use App\Rules\General\FileExtentionCheckRule;
use App\Rules\General\FileLengthCheckRule;

class ProductRequest extends FormRequest
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
            'title' => 'required|unique:products,title,'.request()->id,
            'rating' => 'gte:0|lte:5,',
            'short_description' => 'max:150',
            'message' => 'max:35',
            'url' => 'required',
            'status' => [Rule::in(StatusEnum::toArray())],
            "image"=> ['required','image', new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true))]
        ];

        if(request()->routeIs('admin.product.update')){
            $rules['id']= "required|exists:products,id";
        }
        return $rules;
    }
}
