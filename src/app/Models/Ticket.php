<?php

namespace App\Models;

use App\Enums\TicketStatus;
use App\Models\Core\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'ticket_data' => 'object',
    ];

    protected static function booted(){
        static::creating(function ($ticket) {
            $ticket->uid = str_unique();
        });
    }

    public function messages(){
        return $this->hasMany(Message::class,'ticket_id','id')->latest();
    }

    public function scopePending($q){
        return $q->where("status",TicketStatus::PENDING->value);
    }


    public function scopeSolved($q){
        return $q->where("status",TicketStatus::SOLVED->value);
    }

    public function scopeClosed($q){
        return $q->where("status",TicketStatus::CLOSED->value);
    }

    public function scopeHold($q){
        return $q->where("status",TicketStatus::HOLD->value);
    }

    public function file(){
        return $this->morphOne(File::class, 'fileable');
    }

    public function scopeFilter($q){
        return $q->when(request()->ticket_number,function($query) {
            return $query->where("ticket_number",request()->ticket_number);
        })->when(request()->status,function($query) {
            return $query->where("status",request()->status);
        })->when(request()->user_id,function($query) {
            return $query->where("user_id",request()->user_id);
        });
    }



}
