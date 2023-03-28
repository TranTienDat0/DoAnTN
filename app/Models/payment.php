<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class payment extends Model
{
    use HasFactory, SoftDeletes;
    //Method
    public const METHOD_CASH = 0;
    public const METHOD_CARD = 1;
    public const METHOD_ONLINE = 2;

    public static $methods = [
        self::METHOD_CASH => 'Thanh toán khi nhận hàng',
        self::METHOD_ONLINE => 'Thanh toán trực tuyến',
    ];

    //Method
    public const STATUS_NO = 0;
    public const STATUS_YES = 1;

    public static $status = [
        self::STATUS_NO => 'Chưa thanh toán',
        self::STATUS_YES => 'Đã thanh toán',
    ];

    protected $fillable = [
        'method',
        'status',
    ];
}
