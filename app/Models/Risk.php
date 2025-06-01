<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    protected $fillable = [
        'description',
        'type',
        'urgency',
        'status',
        'response',
        'reported_by',
        'responded_by',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }
}