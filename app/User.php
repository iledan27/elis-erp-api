<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @OA\Schema(
     *  type="object",
     *  schema="User",
     *  description="User model",
     *  title="User",
     *  required={"id","name", "email"},
     *  properties={
     *    @OA\Property(
     *       property="id",
     *       type="integer",
     *       format="int64",
     *     ),
     *     @OA\Property(
     *       property="name",
     *       type="string",
     *     ),
     *     @OA\Property(
     *       property="email",
     *       type="string",
     *     ),
     *     @OA\Property(
     *       property="email_verified_at",
     *       type="string",
     *       format="date-time"
     *     ),
     *     @OA\Property(
     *       property="created_at",
     *       type="string",
     *       format="date-time"
     *     ),
     *     @OA\Property(
     *       property="updated_at",
     *       type="string",
     *       format="date-time"
     *     ),
     *  }
     * )
     */
}
