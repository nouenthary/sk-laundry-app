<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'price',
        'discount',
        'start_date',
        'end_date',
        'unit_type',
        'unit',
        'type',
        'user_id'
    ];
}
