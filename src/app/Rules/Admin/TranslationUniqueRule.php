<?php

namespace App\Rules\Admin;

use App\Enums\StatusEnum;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;

class TranslationUniqueRule implements ValidationRule
{


   public $id,$model,$column,$lang_code ,$message = '';
   public function __construct(string $column , mixed  $model , mixed $id = null )
   {
       $this->column = $column;
       $this->model = $model;
       $this->id  = $id;
   }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $flag = StatusEnum::true->status();
        $translation_data = $this->model::latest()->pluck($this->column)->toArray();
        if($this->id){
            $translation_data  = $this->model::latest()->where('id','!=',$this->id)->pluck($this->column)->toArray();
        }

        foreach($translation_data as $data){
            foreach(system_language() as $language){
                $code = $language->code;

                if(@($data->$code) && ($value[$language->code])){
                    if (strtolower($data->$code) == strtolower($value[$language->code])){
                        $flag = 0;
                        break 2;                    
                    } 
                }
            }
        }

        if($flag != StatusEnum::true->status()){
            $fail(translate('The '.$this->column.' filed must be unique For All Country'));
        }
        
        
    }
}
