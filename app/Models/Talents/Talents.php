<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-07-08
 * Time: 11:51
 */

namespace App\Models\Talents;


use Illuminate\Database\Eloquent\Model;

class Talents extends Model
{
    protected $table = 'talents';

    /**
     * getting image url if it from web or from local
     * @return string
     * */
    public function transformThumb(){
        $image  = $this->talent_thumb;
        if(strpos($image,'http') || strpos($image,'https')){
            return $image;
        }else{
            return  asset($image);
        }
    }
}
