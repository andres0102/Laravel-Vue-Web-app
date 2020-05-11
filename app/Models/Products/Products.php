<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-06-04
 * Time: 11:00
 */

namespace App\Models\Products;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Products extends  Model
{
    protected $table = "products";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'google_id', 'price'
    ];
    /**
    * get product full info
     * @return array
     */
    public  function getProductInfo(){
        $product_id = $this->id;
        /*
         * preparing for product array
         * */
        $allOptions = DB::table('product_option_value')
            ->leftJoin('options','options.id','=','product_option_value.option_id')
            ->leftJoin('options_group','options_group.id','=','options.option_group_id')
            ->where('product_option_value.product_id','=',$product_id)
            ->orderBy('options_group.id')
            ->get();
        $options = [];
        foreach ($allOptions as $allOption) {
            $options[$allOption->id]['name']=$allOption->option_group_name;
            $options[$allOption->id]['options'][]=[
                'name'=>$allOption->option_name,
                'price'=>$allOption->price,
            ];
        }
        $product_info = [
            'id'=>$this->id,
            'name'=> $this->name,
            'description' => $this->description,
            'little_desc'=>$this->little_desc,
            'price'=>$this->price,
            'points' => $this->points,
            'options' => $options,
            'thumb'=> $this->thumb_url,
        ];
        return $product_info;
    }
    /**
     * get product rating
     * @return array
     */
    public function getRating(){
        $product_id = $this->id;
        $count = ProductsReview::where('product_id',$product_id)->count();
        if(!$count){
            return [
                'count'=>0,
                'rating'=>0,
            ];
        }
        $ratingData = ProductsReview::where('product_id',$product_id)->get();
        $ratingTotal = 0;
        foreach ($ratingData as $ratingDatum) {
            $ratingTotal+=(float)$ratingDatum->rating;
        }

        $ratingTotal = (float)$ratingTotal/$count;
        $ratingTotal = number_format($ratingTotal,1,'.','');
        return [
            'count'=>$count,
            'rating'=>$ratingTotal
        ];

    }
    /**
     * get product featured products
     * @return array
     */
    public function getFeatured(){
        $product_id = $this->id;
        $featuredData = ProductsFeatured::where('parent_id',$product_id)->get();
        $products= [];
        foreach ($featuredData as $featuredDatum) {
            $products[]=array(
                'product_id' => $featuredDatum->product_id,
            );
        }
        return $products;

    }
    /**
     * get product category_name
     * @return array
     */
    public function getCategory(){
    $product_id = $this->id;
    $categoryId = CategoryToProduct::where('product_id',$product_id)->first();
        if(!empty($categoryId)) {
            $category = ProductCategory::find($categoryId['category_id']);
            return $category->name;
        }else{
            return '';
        }

    }
    /**
     * creating the right link for thumb of product
     * @return string*/
    public function transformThumb(){
        $image  = $this->thumb_url;
        if(strpos($image,'http') || strpos($image,'https')){
            return $image;
        }else{
            return  asset($image);
        }
    }

    public static function getFashionMustHave($page = 0){
        if(!$page)
            return DB::table('fashion_must_products')->limit(9)->get();
        else
            return DB::table('fashion_must_products')->limit(9)->offset(9*(int)$page)->get();

    }

    public static function getFashionExclusive($page = 0){
        if(!$page)
            return DB::table('fashion_exclusive_products')->limit(9)->get();
        else
            return DB::table('fashion_exclusive_products')->limit(9)->offset(9*(int)$page)->get();

    }

}
