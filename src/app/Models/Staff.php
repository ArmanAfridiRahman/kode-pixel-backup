<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Models\Admin\Role;
use App\Models\Core\File;
use App\Models\Admin;
use App\Models\Core\Otp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    use HasFactory, SoftDeletes;
       /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_name',
        'role_id',
        'created_by',
        'phone',
        'email',
        'status',
        'password',
        'muted_user',
        'blocked_user',
        'last_login'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        "muted_user" => "array",
        "blocked_user" => "array",
    ];

    protected static function booted(){
        static::creating(function ($staff) {
            $staff->uid = str_unique();
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

    public function scopeStaff($q){
        return $q->where('super_admin',StatusEnum::false->status());
    }

    public function role(){
        return $this->belongsTo(Role::class , "role_id","id")->withDefault([
            'name' => 'N/A',
            "permissions" => json_encode([])
       ]);
    }
    public function file(){
        return $this->morphOne(File::class, 'fileable');
    }


    public function otp(){
        return $this->morphOne(Otp::class, 'otpable');
    }


    public function notification(){
        return $this->morphOne(Notification::class, 'notificationable');
    }

    public function scopeFilter($q){
        return $q->when(request()->name,function($query) {
            return $query->where("name","like","%".request()->name."%");
        });
    }
}
