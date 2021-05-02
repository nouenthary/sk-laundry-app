<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'photo',
        'desc',
        'cate_id',
        'created_at',
        'updated_at'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
