<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'client', 'priority', 'subject', 'status', 'assigned', 'category'];

    public function notes(){
        return $this->hasMany(Note::class);
    }

    public function intervention(){
        return $this->belongsTo(Intervention::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}

