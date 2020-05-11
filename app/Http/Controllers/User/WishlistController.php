<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-06-08
 * Time: 14:37
 */

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Products\Products;
use App\Models\Users\Wishlist;
use Tymon\JWTAuth\Facades\JWTAuth;
class WishlistController extends  Controller
{
    private $currentUser;
    public function __construct()
    {
        $this->currentUser = JWTAuth::user();
        if(!$this->currentUser){
            return redirect('/');
        }
    }
    public function index() {
            $products = [];
            $products_db= Wishlist::where('user_id','=',$this->currentUser['id'])->get();
            foreach ($products_db as $product){
                $product_info = Products::find($product->product_id);
                $products[]= array(
                    'wishlist_id'=>$product->id,
                    'url'=>route('market-place-per-product-page',['product_id'=>$product->product_id]),
                    'name'=>$product_info->name,
                    'image'=>$product_info->thumb_url,
                );
            }
            /*sending answer */
            if(empty($products)){
                return response()->json(
                    [
                        'success' => 'success',
                        'answer'=>'WishList is empty',
                        'wishlist' => false,
                    ],
                    200);
            }else{
                return response()->json(
                    [
                        'success' => 'success',
                        'answer'=>'Items in wishlsit',
                        'wishlist' => true,
                        'products' => $products,
                    ],
                    200);
            }

    }
    public function addToWishList($product_id){

        if(Wishlist::where([['user_id','=',$this->currentUser['id']],['product_id','=',$product_id]])->first()){
            return response()->json(
                [
                    'success' => 'success',
                    'answer'=>'Item already in WishList',
                    'wishlist' => false,
                ],
                200);
        }else{
            Wishlist::create([
                'user_id'=> $this->currentUser['id'],
                'product_id' => $product_id
            ]);
            return response()->json(
                [
                    'success' => 'success',
                    'answer'=>'Added to WishList',
                    'wishlist' => true,
                ],
                200);
        }
    }
    public function removeFromWishList($wishlist_id){
        $wishlist = Wishlist::find($wishlist_id);

        if($wishlist->delete()){
            return response()->json(
                [
                    'success' => 'success',
                    'answer'=>'Removed From Wishlist',
                    'type' => 'removed',
                ],
                200);
        }else{
            return response()->json(
                [
                    'success' => 'success',
                    'answer'=>'Not existing wishlist',
                    'type' => 'error',
                ],
                200);
        }

    }

    public function checkInWishList($product_id){
        $wishlist = false;
        if(Wishlist::where([['user_id','=',$this->currentUser['id']],['product_id','=',$product_id]])->first()){
            $wishlist = true;
        }
        return response()->json(
            [
                'success' => 'success',
                'wishlist'=>$wishlist,
            ],
            200);

    }
}
