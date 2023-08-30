<?php

namespace App\Models\Admin;

use App\Models\Admin;
use App\Models\Core\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frontend extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'value' => 'object',
    ];
    protected static function booted(){
        static::creating(function ($frontend) {
            $frontend->uid = str_unique();
        });
    }
    public function file(){
        return $this->morphOne(File::class, 'fileable');
    }

    public function updatedBy(){
        return $this->belongsTo(Admin::class,'updated_by','id')->withDefault([
            'user_name' => 'N/A',
            'name' => 'N/A'
        ]);
    }
}
