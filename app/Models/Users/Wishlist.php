<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-06-04
 * Time: 11:00
 */

namespace App\Models\Users;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wishlist extends  Model
{
    protected $table = "users_wishlist";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'user_id'
    ];

}
