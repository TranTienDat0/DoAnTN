<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;

     // status
     public const STATUS_WAIT = 0;
     public const STATUS_DO = 1;
     public const STATUS_DONE = 2;
 
     public static $status = [
         self::STATUS_WAIT => 'Đang chờ xử lý',
         self::STATUS_DO => 'Đang giao hàng',
         self::STATUS_DONE => 'Giao hàng thành công',
     ];
 
     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
     protected $fillable = [
         'status',
         'total',
     ];
 
     /**
      * The attributes that should be hidden for serialization.
      *
      * @var array<int, string>
      */
     protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at_at'
     ];
}
