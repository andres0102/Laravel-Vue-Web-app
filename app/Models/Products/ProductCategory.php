<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-06-13
 * Time: 15:03
 */

namespace App\Models\Products;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductCategory extends Model
{
    protected $table = 'products_categories';

    /*
     * @return array of */
    public static function getCategoriesForSite(int $site_category = 0){
        $site_categories = [];
        if($site_category){
            $db_query = DB::table('products_categories_to_site_categories')->select('product_category_id')->where('site_category_id',$site_category)->get();
            foreach ($db_query as $item) {
                $site_categories[]=$item->product_category_id;
            }
        }
        return $site_categories;
    }
    /**
     * creating the right link for thumb of product
     * @return string*/
    public function transformThumb(){
        $image  = $this->category_thumb;
        if(strpos($image,'http') || strpos($image,'https')){
            return $image;
        }else{
            return  asset($image);
        }
    }
}
