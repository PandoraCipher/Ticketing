<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'priority', 'subject', 'status', 'assigned'];

    public function notes(){
        return $this->hasMany(Note::class);
    }
}

