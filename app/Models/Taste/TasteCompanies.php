<?php
/**
 * Created by PhpStorm.
 * User: a1
 * Date: 2019-07-09
 * Time: 09:57
 */

namespace App\Models\Taste;


use App\Http\Controllers\Utilities\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TasteCompanies extends Model
{
    protected  $table = 'taste_companies';


    public static function getLocationFilter($place_id){

        return TasteCompanies::select('company_location')->distinct()->where('company_place_id',(int)$place_id)->get();
    }
    public function getCompanyGallery(){
        $gallery_items =[];
        $gallery_in_db =  DB::table('taste_companies_gallery')->where('company_id',$this->id)->get();
        if($gallery_in_db)
            foreach($gallery_in_db as $gallery_item){
                $gallery_items[]=array(
                    'thumb'=>Image::transformImage($gallery_item->item_url),
                );
            }
        return $gallery_items;
    }

    public function getCompanyServices(){
        $service_items = [];
        $service_in_db = DB::table('taste_companies_services')->where('company_id',$this->id)->get();
        if($service_in_db)
            foreach($service_in_db as $service_item){
                $service_items[]=array(
                    'name'=>$service_item->service_name,
                    'thumb'=>Image::transformImage($service_item->service_thumb),
                );
            }
        return $service_items;
    }

    public function getReserveLinksData(){
        $reserve_links = [];
        $reserve_db = DB::table('taste_comanies_reservation_sites')->where('company_id',$this->id)->get();
        if($reserve_db)
            foreach ($reserve_db as $reserve){
                $reserve_links[]= array(
                    'thumb'=>Image::transformImage($reserve->reserv_thumb),
                    'link'=>$reserve->reserve_url,
                    'name'=>$reserve->reserv_name,
                );
            }
        return $reserve_links;
    }
}
