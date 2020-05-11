<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-06-14
 * Time: 11:39
 */

namespace App\Models\Products;


use Illuminate\Database\Eloquent\Model;

class ProductsGalleryItems extends  Model
{
    protected $table='products_gallery_items';

    public function makeHtmlData(){
        $html = '';
        if(strpos($this->item_href,'youtube') !== false){
        preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $this->item_href, $matches);
        $id = $matches[1];
        $width = '100px';
        $height = '100px';
        $html='<iframe id="ytplayer" type="text/html" width="'.$width.'" height="'.$height.'"
                src="https://www.youtube.com/embed/'.$id.'?rel=0&showinfo=0&color=white&iv_load_policy=3"
                frameborder="0" allowfullscreen></iframe>';
        }else{
            $html = '<a href="'.$this->item_href.'"><img src="'.$this->item_href.'"/></a>';
        }
        return $html;
    }
}
