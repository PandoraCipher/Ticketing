<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;
    protected $fillable = ['start_interv', 'end_interv', 'restored_date', 'start_incident', 'downtime_resolution', 'intervention_duration', 'category_id', 'ticket_id', 'kpi_intervention'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
