<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utilities\Image;
use App\Models\Explore\ExploreCategories;
use App\Models\Explore\ExploreClients;
use App\Models\Explore\ExploreFilters;
use App\Models\Explore\ExploreTypes;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ExploreController extends Controller
{
    /**
     * @var string
     */
    const PAGES_FOLDER = 'explore.pages.';

    /**
     * @var string
     */
    const DEFAULT_VIEW = 'explore.pages.default';

    /**
     * displaying main page for explore
     * @return html*/
    public function index()
    {
        /*getting explore type for page */
        $types = ExploreTypes::all();
        return view('explore.index',['types'=>$types]);
    }

    /**
     * showing client list from explore type
     * @param string $type - explore type id
     * @return html
     */
    public function showClients(string $type_url, string $category_url = '')
    {
        $gallery = [];
        $type =  ExploreTypes::select('id','explore_type_name','explore_type_thumb')->where('explore_type_seourl',$type_url)->first();
        if(!$type){
                return abort(404);
        }
        /*
         * getting categories if they exists
         * */
        $items = [];
        $title = $type->explore_type_name;
        $filters=[];
        /*
          * getting clients from type of our explore
          *
         * */
        if($category_url){
            $category = ExploreCategories::where('cat_seo_url',$category_url)->first();
            $title = $category->cat_name;
            $clients =ExploreClients::where('cat_id',$category->id)->get();
            foreach ($clients as $client){
                $items[]=array(
                    'id'=>$client->id,
                    'name'=>$client->cl_name,
                    'thumb'=>$client->transformThumb(),
                    'link'=>route('explore-show-client',['type_url'=>$type_url,'client_url'=>$client->cl_seo_url]),

                );
            }
            /*category url */
        }else{
            
            $categoriesId=[];
            $categories = ExploreCategories::where('type_id',$type->id)->get();
            foreach ($categories as $category){
                $items[] = array(
                    'id'=>$category->id,
                    'name'=>$category->cat_name,
                    'thumb'=>$category->transformThumb(),
                    'link'=>route('explore-subpage',['type_url'=>$type_url,'category_url'=>$category->cat_seo_url]),
                );
            $categoriesId[]=$category->id;
            }
            $clientsId= [];
            $clients =ExploreClients::where([['type_id',$type->id],['cat_id',0]])->get();

            foreach ($clients as $client){

                $items[]=array(
                    'id'=>$client->id,
                    'name'=>$client->cl_name,
                    'thumb'=>$client->transformThumb(),
                    'link'=>route('explore-show-client',['type_url'=>$type_url,'client_url'=>$client->cl_seo_url]),

                );
                $clientsId[]=$client->id;
            }
            /*
             * getting filters for categories and items
            */

           $filters=ExploreFilters::getFilters($categoriesId,$clientsId);


        }
        $gallery_in_db = $type->getGallery();
        foreach ($gallery_in_db as $item){
            $gallery[]=Image::transformImage($item->item_url);
        }
        
        return view(self::DEFAULT_VIEW, ['category' => ucfirst($title),'filter'=>$filters,'items'=>json_encode($items),'type'=>$type, 'type_url'=>$type_url,'category_url'=>$category_url ,'gallery'=>$gallery]);
    }

    public function showClient(string $type_url, string $client_url)
    {

        $client = ExploreClients::where('cl_seo_url',$client_url)->first();
        if(!$client) {
            return abort(404);
        }
        $services = $client->getServices();
        $gallery = $client->getGallery();
        if($client->type){
            return view('explore.pages.profile-club', ['client' => $client, 'services' => $services, 'gallery' => $gallery]);
        }else {
            return view('explore.pages.profile', ['client' => $client, 'services' => $services, 'gallery' => $gallery]);
        }
    }
    /*
     * return categories and clients with filter
     * @param Illuminate\Http\Request $request -  request data
     * @return json array */
    public function filter(Request $request){
        $get =$request->all();
        $type_url = $get['typeurl'];
        $category_url = $get['categoryurl'];
        $type =  ExploreTypes::select('id','explore_type_name','explore_type_thumb')->where('explore_type_seourl',$type_url)->first();
        if(!$type){
            return abort(404);
        }
        /*
         * getting categories if they exists
         * */
        $items = [];
        $title = $type->explore_type_name;
        $filters=[];
        /*
          * getting clients from type of our explore
          *
         * */
        $clientsId= [];
        $categoriesId=[];
        if($category_url){
            $category = ExploreCategories::where('cat_seo_url',$category_url)->first();
            $clients =ExploreClients::where('cat_id',$category->id)->get();
            foreach ($clients as $client){
                $clientsId[]= $client->id;
            }
            /*category url */
        }else {

            $clients = ExploreClients::where([['type_id', $type->id], ['cat_id', 0]])->get();

            foreach ($clients as $client) {
                $clientsId[] = $client->id;
            }

            $categories = ExploreCategories::where('type_id', $type->id)->get();
            foreach ($categories as $category) {
                $categoriesId[] = $category->id;
            }
            /*
             * getting items  for categories and items with filter
            */
        }
            $items  = ExploreClients::getClientsWithFilter($get['filter_id'],$categoriesId,$clientsId,$type_url);
            return response()->json([
                'status' => 'success',
                'msg' => 'Success get',
                'items'=>$items,
                'type'=>$type->id,
            ], 200);
    }
    /*get new category*/

    public function showStore()
    {
        return 1;
        return view('explore.pages.store');
    }


    public function showStoreProducts()
    {
        return view('explore.pages.products');
    }

    public function showStoreProduct()
    {
        return view('explore.pages.product');
    }

    public function showNightLifeProfile()
    {
        return view('explore.pages.nightlife-profile');
    }

    public function showDayClubsProfile()
    {
        return view('explore.pages.dayclubs-profile');
    }

    public function showNightlifeCategory($category)
    {
        return view('explore.pages.nightlife-subpage', ['category' => ucfirst($category)]);
    }
//    public function test()
//    {
//        $category=[
//            'cat_name'=>"Art",
//            'id'=>'9',
//        ];
//            for ($i = 1; $i < 10; $i++) {
//                DB::statement("INSERT INTO `explore_clients` (`id`, `cl_name`, `type_id`, `cat_id`, `cl_thumb`, `cl_desc`, `type`, `cl_place`, `cl_open`, `cl_phone`, `cl_email`, `cl_web`, `cl_fb`, `cl_ytb`, `cl_twt`, `cl_seo_url`, `created_at`, `updated_at`) VALUES (NULL, '" . $category['cat_name']. " " . $i . "', '".$category['id']."', '0', 'assets/img/adventure/adventure" . $i . ".png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam consequat, mi a blandit sollicitudin, eros neque sodales felis, nec consequat ex urna eu ipsum. Fusce vel neque id tortor tempor pharetra eu non urna. Sed sed metus euismod, varius sem ac, cursus quam. Nulla eu orci sit amet purus aliquam gravida at lacinia odio. Duis non erat sem. Sed dignissim scelerisque libero, in ornare ligula aliquam vel. Fusce rutrum justo ac egestas malesuada. Pellentesque mi odio, suscipit in orci in, tincidunt semper enim. Lorem ipsum dolor sit amet, consectetur adipiscing elit.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam consequat, mi a blandit sollicitudin, eros neque sodales felis, nec consequat ex urna eu ipsum. Fusce vel neque id tortor tempor pharetra eu non urna. Sed sed metus euismod, varius sem ac, cursus quam. Nulla eu orci sit amet purus aliquam gravida at lacinia odio. Duis non erat sem. Sed dignissim scelerisque libero, in ornare ligula aliquam vel. Fusce rutrum justo ac egestas malesuada. Pellentesque mi odio, suscipit in orci in, tincidunt semper enim. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '0', '445 Mount Eden Road, Mount Eden Auckland', 'Monday - Friday 8AM - 9PM \r\nSaturday - Sunday 1PM - 10PM', '23 4567 8901 / 123 4567 8901', 'olsovka@gmail.com', 'www.website.com', 'https://www.facebook.com/', 'https://www.youtube.com/', 'https://www.twitter.com/', '" . $this->generateSeoURL($category['cat_name']) . "" . $i . "', '2019-06-18 17:02:05', '2019-06-17 11:59:41')
//");
//                $id = DB::getPdo()->lastInsertId();
//                for ($j = 1; $j < 6; $j++) {
//                    DB::statement("INSERT INTO `explore_clients_gallery` (`id`, `exp_cl_id`, `item_url`, `created_at`, `updated_at`) VALUES (NULL, '" . $id . "', 'assets/img/adventure/adventure".$j.".png', '2019-07-16 13:10:39', '2019-06-18 14:25:15')");
//                }
//                for($j=1;$j<4;$j++){
//                    DB::statement("INSERT INTO `explore_clients_services` (`id`, `cl_id`, `service_name`, `service_thumb`, `created_at`, `updated_at`) VALUES (NULL, '" . $id . "', 'Service ".$j."', 'assets/img/adventure/adventure".$j.".png', '2019-07-16 12:56:40', '2019-06-17 20:06:54')");
//                }
//
//            }
//    }
//    public function test_en()
//    {
//        $cat = DB::table('explore_categories')->get();
//        foreach ($cat as $category) {
//            $i = 1;
//            if ($category->cat_name == 'Bars') {
//                $i = 2;
//            }
//            for ($i = $i; $i < 10; $i++) {
//                DB::statement("INSERT INTO `explore_clients` (`id`, `cl_name`, `type_id`, `cat_id`, `cl_thumb`, `cl_desc`, `type`, `cl_place`, `cl_open`, `cl_phone`, `cl_email`, `cl_web`, `cl_fb`, `cl_ytb`, `cl_twt`, `cl_seo_url`, `created_at`, `updated_at`) VALUES (NULL, '" . $category->cat_name . " " . $i . "', '2', '" . $category->id . "', 'assets/img/nightlife/nightlife" . $i . ".png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam consequat, mi a blandit sollicitudin, eros neque sodales felis, nec consequat ex urna eu ipsum. Fusce vel neque id tortor tempor pharetra eu non urna. Sed sed metus euismod, varius sem ac, cursus quam. Nulla eu orci sit amet purus aliquam gravida at lacinia odio. Duis non erat sem. Sed dignissim scelerisque libero, in ornare ligula aliquam vel. Fusce rutrum justo ac egestas malesuada. Pellentesque mi odio, suscipit in orci in, tincidunt semper enim. Lorem ipsum dolor sit amet, consectetur adipiscing elit.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam consequat, mi a blandit sollicitudin, eros neque sodales felis, nec consequat ex urna eu ipsum. Fusce vel neque id tortor tempor pharetra eu non urna. Sed sed metus euismod, varius sem ac, cursus quam. Nulla eu orci sit amet purus aliquam gravida at lacinia odio. Duis non erat sem. Sed dignissim scelerisque libero, in ornare ligula aliquam vel. Fusce rutrum justo ac egestas malesuada. Pellentesque mi odio, suscipit in orci in, tincidunt semper enim. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '1', '445 Mount Eden Road, Mount Eden Auckland', 'Monday - Friday 8AM - 9PM \r\nSaturday - Sunday 1PM - 10PM', '23 4567 8901 / 123 4567 8901', 'olsovka@gmail.com', 'www.website.com', 'https://www.facebook.com/', 'https://www.youtube.com/', 'https://www.twitter.com/', '" . $this->generateSeoURL($category->cat_name) . "" . $i . "', '2019-06-18 17:02:05', '2019-06-17 11:59:41')
//");
//                $id = DB::getPdo()->lastInsertId();
//                for ($j = 1; $j <= 6; $j++) {
//                    DB::statement("INSERT INTO `explore_clients_gallery` (`id`, `exp_cl_id`, `item_url`, `created_at`, `updated_at`) VALUES (NULL, '" . $id . "', 'assets/img/profile/gallery" . $j . ".png', '2019-07-16 13:10:39', '2019-06-18 14:25:15')");
//                }
//                DB::statement("INSERT INTO `explore_clients_services` (`id`, `cl_id`, `service_name`, `service_thumb`, `created_at`, `updated_at`) VALUES (NULL, '" . $id . "', 'Table Bottle Service', 'assets/img/profile/dayclub_service1.png', '2019-07-16 12:56:40', '2019-06-17 20:06:54')");
//                DB::statement("INSERT INTO `explore_clients_services` (`id`, `cl_id`, `service_name`, `service_thumb`, `created_at`, `updated_at`) VALUES (NULL, '" . $id . "', 'Group Admision
//', 'assets/img/profile/dayclub_service2.png', '2019-07-16 12:56:40', '2019-06-17 20:06:54')");
//                DB::statement("INSERT INTO `explore_clients_services` (`id`, `cl_id`, `service_name`, `service_thumb`, `created_at`, `updated_at`) VALUES (NULL, '" . $id . "', 'Private Party', 'assets/img/profile/dayclub_service3.png', '2019-07-16 12:56:40', '2019-06-17 20:06:54')");
//            }
//        }
//    }
    function generateSeoURL($string, $wordLimit = 0){
        $separator = '-';

        if($wordLimit != 0){
            $wordArr = explode(' ', $string);
            $string = implode(' ', array_slice($wordArr, 0, $wordLimit));
        }

        $quoteSeparator = preg_quote($separator, '#');

        $trans = array(
            '&.+?;'                    => '',
            '[^\w\d _-]'            => '',
            '\s+'                    => $separator,
            '('.$quoteSeparator.')+'=> $separator
        );

        $string = strip_tags($string);
        foreach ($trans as $key => $val){
            $string = preg_replace('#'.$key.'#i'.(1 ? 'u' : ''), $val, $string);
        }

        $string = strtolower($string);

        return trim(trim($string, $separator));
    }
}

