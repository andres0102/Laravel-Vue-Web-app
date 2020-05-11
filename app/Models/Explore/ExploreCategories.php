<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-06-17
 * Time: 12:20
 */

namespace App\Models\Explore;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExploreCategories extends Model
{
    protected  $table = 'explore_categories';

    /**
     * getting image url if it from web or from local
     * @return string
     * */
    public function transformThumb()
    {
        $image = $this->thumb;
        if (strpos($image, 'http') || strpos($image, 'https')) {
            return $image;
        } else {
            return asset($image);
        }
    }

}
