<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;
use App\Models\Admin;

class Language extends Model
{
    use HasFactory;


    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($language) {
            $language->uid = str_unique();
        });
    }
    public function createdBy(){
        return $this->belongsTo(Admin::class,'created_by','id')->withDefault([
            'user_name' => 'N/A',
        ]);
    }
    public function updatedBy(){
        return $this->belongsTo(Admin::class,'updated_by','id')->withDefault([
            'user_name' => 'N/A',
        ]);
    }
    public function scopeDefault($q){
        return $q->where('is_default',(StatusEnum::true)->status());
    }
    public function scopeActive($q){
        return $q->where('status',(StatusEnum::true)->status());
    }

}
