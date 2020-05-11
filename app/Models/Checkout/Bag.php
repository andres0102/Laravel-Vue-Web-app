<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-06-04
 * Time: 21:15
 */

namespace App\Models\Checkout;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bag extends  Model
{
    protected $table = 'bag';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];
    public function getBagItems(){
        $bagId = $this->id;
        $items=DB::table('bag_items')
            ->where('bag_id','=',$bagId)
            ->get();
        return $items;

    }
    public function getCountBagItems(){
        $bagId = $this->id;
        $items=DB::table('bag_items')
            ->where('bag_id','=',$bagId)
            ->get();
        $count =0;
        foreach ($items as $item) {
            $count+=$item->quantity;
        }
        return $count;

    }
    public function getBagTotal(){
        $bagId = $this->id;
        $items = BagItems::where('bag_id',$bagId)->get();
        $amount = 0;
        foreach ($items as $item){
            $amount+=$item->total;
        }
        return $amount;
    }
}
