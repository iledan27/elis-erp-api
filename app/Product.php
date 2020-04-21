<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @OA\Schema(
     *  type="object",
     *  schema="Product",
     *  description="Product model",
     *  title="Product",
     *  required={"id", "name"},
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
