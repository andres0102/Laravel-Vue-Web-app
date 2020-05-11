<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-06-17
 * Time: 11:32
 */

namespace App\Models\Explore;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExploreClients extends Model
{
    protected  $table = 'explore_clients';

    /**
     * getting gallery from our category
     * @return array
     */
    public function getGallery(){
        $gallery = Db::table('explore_clients_gallery')->where('exp_cl_id',$this->id)->get();
        $galleryItems= [];
        foreach ($gallery as $item){
            if(strpos($item->item_url,'http') || strpos($item->item_url,'https')){
                $image = $item->item_url;;
            }else{
                $image =   asset($item->item_url);
            }
            $galleryItems[]=array(
                'id'=>$item->id,
                'thumb' => $image,
            );
        }
        return $galleryItems;
    }
    /**
     * getting image url if it from web or from local
     * @return string
     * */
    public function transformThumb(){
        $image  = $this->cl_thumb;
        if(strpos($image,'http') || strpos($image,'https')){
            return $image;
        }else{
            return  asset($image);
        }
    }
    public static function getClientsWithFilter($filters_id,$cats_id, $clients_id,$type_url){
        $categories = null;
        $clients = null;
        if($filters_id == 0){
            $categories = ExploreCategories::whereIn('id', $cats_id)->get();
        }else {
            if (!empty($cats_id)) {
                $categories = ExploreFilters::where('filter_value_id', $filters_id)->whereIn('cat_id', $cats_id)->get();
            }
        }
        if($filters_id == 0){
                $clients = ExploreClients::whereIn('id', $clients_id)->get();
        }else {
            if (!empty($clients_id))
                $clients = ExploreFilters::where('filter_value_id', $filters_id)->whereIn('client_id', $clients_id)->get();
        }


        $items = [];
        foreach ($clients as $client){
            if($filters_id == 0) {
                $clientInfo = ExploreClients::where([['id', $client->id], ['cat_id', 0]])->first();
            }else {
                $clientInfo = ExploreClients::where([['id', $client->client_id], ['cat_id', 0]])->first();
            }
            $items[]=array(
                'id'=>$clientInfo->id,
                'name'=>$clientInfo->cl_name,
                'thumb'=>$clientInfo->transformThumb(),
                'link'=>route('explore-show-client',['type_url'=>$type_url,'client_url'=>$clientInfo->cl_seo_url]),

            );
        }
        foreach ($categories as $category){
            if($filters_id == 0) {
                $categoryInfo = ExploreCategories::where('id', $category->id)->first();
            }else {
                $categoryInfo = ExploreCategories::where('id', $category->cat_id)->first();
            }
            $items[] = array(
                'id'=>$categoryInfo->id,
                'name'=>$categoryInfo->cat_name,
                'thumb'=>$categoryInfo->transformThumb(),
                'link'=>route('explore-subpage',['type_url'=>$type_url,'category_url'=>$categoryInfo->cat_seo_url]),
            );
        }
        return $items;
    }
    public function getServices(){
        $services = [];
        if(Db::table('explore_clients_services')->where('cl_id',$this->id)->count()) {
         $servicesDb = Db::table('explore_clients_services')->where('cl_id', $this->id)->get();
         foreach ($servicesDb as $serviceDb){
             $image  = '';
             if(strpos($serviceDb->service_thumb,'http') || strpos($serviceDb->service_thumb,'https')){
                 $image = $serviceDb->service_thumb;;
             }else{
                 $image =   asset($serviceDb->service_thumb);
             }
             $services[] = array(
                    'name'=>$serviceDb->service_name,
                 'thumb'=>$image,
             );
         }
         return $services;
        }else{
            return [];
        }

    }


}
