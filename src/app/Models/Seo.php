<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use HasFactory;

    

    protected $guarded = [];

    protected $casts = [
        'meta_keywords' => 'object',
        'meta_description' => 'object',
        'meta_title' => 'object',
        'title' => 'object',
    ];
    
    protected static function booted(){
        static::creating(function ($seo) {
            $seo->uid = str_unique();
        });
    }

    public function updatedBy(){
        return $this->belongsTo(Admin::class,'updated_by','id')->withDefault([
             'name' => 'N/A',
             'user_name' => 'N/A',
        ]);
    }


    public function scopeFilter($q){
        return $q->when(request()->title,function($query){
            $title = request()->title;
            return $query->whereRaw("JSON_CONTAINS(title->'$.*', '\"$title\"')");
        });
    }

}
