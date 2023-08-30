<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;

class MailGateway extends Model
{
    use HasFactory;

    
    protected $guarded = [];

    protected $casts = [
        'credential' => 'object',
    ];
    protected static function booted(){
        static::creating(function ($gateway) {
            $gateway->uid = str_unique();
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

    public function scopeFilter($q){
        return $q->when(request()->name,function($query) {
            return $query->where("name","like","%".request()->name."%");
        });
    }
}
