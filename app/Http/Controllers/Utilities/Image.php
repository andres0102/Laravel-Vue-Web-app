<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-07-09
 * Time: 10:00
 */

namespace App\Http\Controllers\Utilities;


use App\Http\Controllers\Controller;

class Image extends  Controller
{
    public static function transformImage($image){
        if(strpos($image,'http') || strpos($image,'https')){
            return $image;
        }else{
            return  asset($image);
        }
    }

}
