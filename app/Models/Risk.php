<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    protected $fillable = [
        'reported_by', 'description', 'type', 'status', 'response',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}