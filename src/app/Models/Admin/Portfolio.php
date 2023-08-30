<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\Core\File;
use App\Enums\StatusEnum;

class Portfolio extends Model
{
    use HasFactory;

     protected $guarded = [];

     protected static function booted()
    {
        static::creating(function ($portfolio) {
            $portfolio->uid = str_unique();
        });
    }
    public function createdBy(){
        return $this->belongsTo(Admin::class, 'created_by', 'id')->withDefault([
            'user_name' => 'N/A',
            'name' => 'N/A'
        ]);
    }
    public function updatedBy(){
        return $this->belongsTo(Admin::class, 'updated_by', 'id')->withDefault([
            'user_name' => 'N/A',
            'name' => 'N/A'
        ]);
    }
    public function file(){
        return $this->morphOne(File::class, 'fileable');
    }
    public function scopeActive($q){
        return $q->where('status',(StatusEnum::true)->status());
    }
    public function scopeFilter($q,$request)
    {
        return $q->when($request->title,function($query) use($request){
            return $query->where("title","like","%".$request->title."%");
        });
    }
}
