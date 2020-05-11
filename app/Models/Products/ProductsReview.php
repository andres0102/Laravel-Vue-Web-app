<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-06-13
 * Time: 13:00
 */

namespace App\Models\Products;


use Illuminate\Database\Eloquent\Model;

class ProductsReview extends  Model
{
    protected $table = "products_rating";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','product_id','rating'
    ];
}
