<?php

namespace App\Models\Admin;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;

class Role extends Model
{
    use HasFactory;


    protected $guarded = [];
    protected static function booted()
    {
        static::creating(function ($role) {
            $role->uid = str_unique();
        });
    }
    public function createdBy(){
        return $this->belongsTo(Admin::class,'created_by','id')->withDefault([
            'user_name' => 'N/A',
            'name' => 'N/A'
        ]);
    }
    public function updatedBy(){
        return $this->belongsTo(Admin::class,'updated_by','id')->withDefault([
            'user_name' => 'N/A',
            'name' => 'N/A'
        ]);
    }

    public function scopeActive($q){
        return $q->where('status',StatusEnum::true->status());
    }

    public function staff(){
        return $this->hasMany(Admin::class,'role_id','id')->latest();
    }

    public function scopeFilter($q){
        return $q->when(request()->name,function($query) {
            return $query->where("name","like","%".request()->name."%");
        });
    }
}
