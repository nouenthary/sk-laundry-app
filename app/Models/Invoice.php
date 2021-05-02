<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'user_id',
        'total',
        'received_riel',
        'received_dollar',
        'total_riel',
        'status',
        'pay_by',
        'print',
        'pay_status',
        'tran_id',
        'qrcode',
        'created_at',
        'updated_at'
    ];   
}
