<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = ['file', 'author', 'ticket_id', 'content', 'assigned_id', 'status', ];

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function assigned(){
        return $this->belongsTo(User::class);
    }
}
