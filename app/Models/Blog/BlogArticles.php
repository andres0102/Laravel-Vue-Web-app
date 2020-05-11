<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-07-08
 * Time: 09:45
 */

namespace App\Models\Blog;


use Illuminate\Database\Eloquent\Model;

class BlogArticles extends  Model
{
    protected  $table = 'blog_articles';


    /**
     * getting image url if it from web or from local
     * @return string
     * */
    public function transformThumb(){
        $image  = $this->article_thumb;
        if(strpos($image,'http') || strpos($image,'https')){
            return $image;
        }else{
            return  asset($image);
        }
    }
}
