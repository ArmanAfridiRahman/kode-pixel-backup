<?php

namespace App\Http\Requests;

use App\Models\Seo;
use App\Rules\Admin\TranslationRule;
use App\Rules\Admin\TranslationUniqueRule;
use Illuminate\Foundation\Http\FormRequest;

class SeoRequest extends FormRequest
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
            'id' => ["required" ,'exists:seos,id'],
            'title' => ['array', new TranslationRule("title"),new TranslationUniqueRule('title', new Seo() ,request()->id)],            
            'meta_title' => ['array'],
            'meta_description' => ['array'],
            'meta_keywords' => ['array'],
        ];

        $ignoreIdetifier = [
            'home',
            'login',
            'register',
            'verification',
        ];

        if(!in_array(request()->identifier,$ignoreIdetifier)){
            $rules ['slug'] =  "unique:seos,slug,".request()->id ;
        }
        
        return  $rules;
    }
}
