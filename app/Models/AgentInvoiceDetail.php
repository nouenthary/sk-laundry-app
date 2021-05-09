<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentInvoiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'product_id',
        'service_id',
        'qty',
        'weight',
        'price',
        'discount',
        'total',
        'date',
        'time',
        'status',
        'pay_type',
        'agent_id',
        'user_id',
        'percent_commission',
        'commission',
        'agent_invoice_id',
        'created_at',
        'updated_at'
    ];

}
