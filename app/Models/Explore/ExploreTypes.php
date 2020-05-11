<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-06-15
 * Time: 16:31
 */

namespace App\Models\Explore;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExploreTypes extends Model
{
    protected $table ='explore_types';

    /**
     * getting image url if it from web or from local
     * @return string
     * */
    public function transformThumb(){
        $image  = $this->explore_type_thumb;
        if(strpos($image,'http') || strpos($image,'https')){
            return $image;
        }else{
            return  asset($image);
        }
    }

    public function getGallery(){
        return DB::table('explore_types_gallery')->where('explore_type_id',$this->id)->get();
    }
}
