<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_name',
        'tel',
        'address',
        'status',
        'location',
        'user_id',
        'created_at',
        'updated_at'
    ];
}
