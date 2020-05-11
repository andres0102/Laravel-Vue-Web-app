<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-06-04
 * Time: 22:57
 */

namespace App\Models\Checkout;


use Illuminate\Database\Eloquent\Model;

class BagItems extends Model
{
    protected $table ='bag_items';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id','quantity','price','options','bag_id','total'
    ];
}
