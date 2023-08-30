<?php

namespace App\Models\Admin;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Template extends Model
{
    use HasFactory;
    protected $guarded = [];


    protected $casts = [
        'sort_code' => 'object',
    ];


    protected static function booted(){
        static::creating(function ($template) {
            $template->uid = str_unique();
        });
    }

    public function createdBy(){
        return $this->belongsTo(Admin::class,'created_by','id')->withDefault([
            'name' => 'N/A',
        ]);
    }
    public function updatedBy(){
        return $this->belongsTo(Admin::class,'updated_by','id')->withDefault([
            'name' => 'N/A',
        ]);
    }

    public function scopeFilter($q){
        return $q->when(request()->name,function($query) {
            return $query->where("name","like","%".request()->name."%");
        });
    }


}
