<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;



    protected $casts = [
        'agent_info' => 'object',

    ];

    protected $guarded = [];

    public function updatedBy(){
        return $this->belongsTo(Admin::class,'updated_by','id')->withDefault([
            'user_name' => 'N/A',
            'name' => 'N/A',
        ]);
    }

    public function scopeFilter($q){
        return $q->when(request()->ip,function($query) {
            return $query->where("ip_address",request()->ip);
        });
    }

}
