<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-06-15
 * Time: 09:40
 */

namespace App\Models\Companies;


use App\Models\Products\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Companies extends  Model
{
    protected $table = 'companies';

    /**
     * getting image url if it from web or from local
     * @return string
     * */
    public function transformThumb(){
        $image  = $this->company_thumb;
        if(strpos($image,'http') || strpos($image,'https')){
            return $image;
        }else{
            return  asset($image);
        }
    }

    public static function getCompaniesTypes(){
        return DB::table('companies_type')->get();
    }
    public function getCompanyProducts(){
        return Products::where('company_id',$this->id)->get();
    }

    public function getCompanyCategories(){
        $db = DB::table('products_categories_to_company')
            ->leftJoin('products_categories','products_categories.id','=','products_categories_to_company.category_id')
            ->where('products_categories_to_company.company_id',$this->id)
            ->get();
        return $db;
    }
    public static function getCompaniesFromSitecategory($site_category){
        return Db::table('companies_to_sites_categories')->where('site_category_id',$site_category)->get();
    }


}
