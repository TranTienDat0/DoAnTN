<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class products extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'price',
        'quantity',
        'categories_id',
    ];

    protected $dates = [
        'date_of_manufacture',
        'expiry',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
