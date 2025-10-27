<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'cadence', 'filters', 'next_run_at'
    ];

    protected $casts = [
        'filters' => 'array',
        'next_run_at' => 'datetime',
    ];
}
