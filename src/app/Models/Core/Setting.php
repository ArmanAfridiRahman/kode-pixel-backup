<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;


    protected $guarded = [];
    

    public function file(){
        return $this->morphOne(File::class, 'fileable');
    }
}
