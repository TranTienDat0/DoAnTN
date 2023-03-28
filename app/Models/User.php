<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    //role
    public const ROLE_CUSTOMER = 0;
    public const ROLE_STAFF = 1;
    public const ROLE_ADMIN_ROOT = 2;

    public static $roles = [
        self::ROLE_CUSTOMER => 'Khách hàng',
        self::ROLE_STAFF => 'Nhân viên',
        self::ROLE_ADMIN_ROOT => 'người quản trị',
    ];

    // gender
    public const GENDER_MALE = 0;
    public const GENDER_FEMALE = 1;
    public const GENDER_OTHER = 2;

    public static $genders = [
        self::GENDER_MALE => 'Nam',
        self::GENDER_FEMALE => 'Nữ',
        self::GENDER_OTHER => 'Khác',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'gender',
        'date_of_birth',
        'email',
        'phone',
        'password',
        'address',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    protected $dates = [
        'date_of_birth',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
