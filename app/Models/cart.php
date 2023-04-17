<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $fillable = [
        'user_id',
        'product_id',
        'order_id', 
        'quantity',
        'amount',
        'price',
        'status'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function product()
    {
        return $this->belongsTo(products::class);
    }
    public function order()
    {
        return $this->belongsTo(order::class);
    }
}
