<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utilities\Image;
use App\Models\Taste\TasteCompanies;
use App\Models\Taste\TastePlaces;
use Illuminate\Http\Request;

class TasteController extends Controller
{
    public function index()
    {
        return view('taste.index');
    }

    public function showBar()
    {
        return view('taste.bar');
    }

    public function showBarProfile()
    {
        return view('taste.bar-profile');
    }

    public function showBrewerie()
    {
        return view('taste.brewerie');
    }

    public function showBrewerieProfile()
    {
        return view('taste.brewerie-profile');
    }

    public function showDistilleries()
    {
        return view('taste.distilleries');
    }

    public function showDistilleriesProfile()
    {
        return view('taste.distilleries-profile');
    }

    public function showBars()
    {
        return view('taste.bars-breweries-distilaries');
    }

    public function showBarWineLoopContact()
    {
        return view('taste.bars-wine-loop-contact');
    }

    public function showWinery()
    {
        return view('taste.wineries-visit');
    }

    public function showBuyWine()
    {
        return view('taste.buy-wine');
    }

    public function showWineClub()
    {
        return view('taste.wine-club');
    }

    public function showExpEvents()
    {
        return view('taste.wine-loop-events');
    }

    public function showWineVisit()
    {
        return view('taste.wine-visit');
    }

    public function showWinePartner()
    {
        return view('taste.wine-partner');
    }

    public function showWineContact()
    {
        return view('taste.wine-contact');
    }

    public function showWineProfile()
    {
        return view('taste.wine-loop-profile');
    }

    public function showPartner()
    {
        return view('taste.community-partners');
    }

    public function showWineryEvents()
    {
        return view('taste.event');
    }

    public function showCoffeeShops()
    {
        return view('taste.coffee-shops');
    }

    public function showCoffeeShopsProfile()
    {
        return view('taste.coffe-profile');
    }

    public function showFoodTruck()
    {
        return view('taste.food-truck');
    }

    public function showFoodTruckProfile()
    {
        return view('taste.food-truck-profile');
    }

    public function showRestaurants()
    {
        return view('taste.restaurants');
    }
    /*
     * show companies for taste place type
     * @param string $place_url - url of place
     * @return html
     * */
    public function showPlaceCompanies($place_url){
        $taste_place = TastePlaces::where('place_seo_url',$place_url)->first();
        
        if (!$taste_place) {
            return abort(404);
        }

        $view = 'taste.default';
        
        if ($taste_place->id == 1) {
            $view = 'taste.restaurants';
        }

        $companies_in_db = TasteCompanies::where('company_place_id',$taste_place->id)->get();
        $companies = [];
        if($companies_in_db)
            foreach ($companies_in_db as $company_db){
                $companies[] = array(
                    'name'=>$company_db->company_name,
                    'thumb'=>Image::transformImage($company_db->company_thumb),
                    'link'=>route('taste-show-company',['company_url'=>$company_db->company_seo_url]),
                    'desc'=>$company_db->company_short_desc,
                );
            }
        /*
         * place like restaurants etc
         * */
        $place = [
            'id'=>$taste_place->id,
            'name' => $taste_place->place_name,
            'thumb' => Image::transformImage($taste_place->place_thumb),
        ];
        $location_filter = TasteCompanies::getLocationFilter($taste_place->id);

        return view($view,['companies'=>json_encode($companies),'place'=>$place,'location_filter'=>$location_filter]);
    }
    /**
     * filter items by place id and location value
     * @param Request $request - request data from $_GET
     * @return json array
     * */
    public function filterCompanies(Request $request){
        if($request->get('location'))
            $companies_in_db = TasteCompanies::where([['company_place_id','=',$request->get('place_id')],['company_location','=',$request->get('location')]])->get();
        else
            $companies_in_db = TasteCompanies::where([['company_place_id','=',$request->get('place_id')]])->get();
        $companies = [];
        if($companies_in_db)
            foreach ($companies_in_db as $company_db){
                $companies[] = array(
                    'name'=>$company_db->company_name,
                    'thumb'=>Image::transformImage($company_db->company_thumb),
                    'link'=>route('taste-show-company',['company_url'=>$company_db->company_seo_url]),
                    'desc'=>$company_db->company_short_desc,
                );
            }
        else
            return  response()->json([
                'status' => 'error',
                'msg' => 'No companies',
                'error'=>'no_products',
            ], 400);
        return  response()->json([
            'status' => 'success',
            'msg' => 'Success companies',
            'companies'=>$companies,
        ], 200);
    }
    /**
     * search companies by search value
     * @param Request $request - $_GET request
     * @return json array
     */
    public function searchCompanies(Request $request){
        $companies = [];
        $companies_in_db = TasteCompanies::where([['company_name','LIKE','%'.$request->get('search').'%'],['company_place_id','=',$request->get('place_id')]])->get();
        if($companies_in_db)
            foreach ($companies_in_db as $company_db){
                $companies[] = array(
                    'name'=>$company_db->company_name,
                    'thumb'=>Image::transformImage($company_db->company_thumb),
                    'link'=>route('taste-show-company',['company_url'=>$company_db->company_seo_url]),
                    'desc'=>$company_db->company_short_desc,
                );
            }
        return  response()->json([
            'status' => 'success',
            'msg' => 'Success companies',
            'companies'=>$companies,
        ], 200);

    }

    /**
     * Show company data
     * 
     * @param  string $taste_company_url - company seo url
     * @return html
    */

    public function showCompany($taste_company_url)
    {
        $company_info = TasteCompanies::where('company_seo_url', $taste_company_url)->first();

        if (!$company_info) {
            return abort(404);
        }

        $view = 'taste.food-truck-profile';
        $services = [];
        $gallery = [];
        if ($company_info->company_place_id == 2) {
            $services = $company_info->getCompanyServices();
            $gallery = $company_info->getCompanyGallery();
            $view = 'taste.coffe-profile';
        }
        //chef_image
        $chef_image = Image::transformImage($company_info->chef_thumb);
        $reserve_link = $company_info->getReserveLinksData();
        return view($view, ['company_thumb'=>Image::transformImage($company_info->company_thumb),'company_info'=>$company_info,'gallery'=>$gallery, 'services'=>$services,'reserve_links'=>$reserve_link,'chef_image'=>$chef_image]);
    }
    
    public function showBookTasting()
    {
        return view('taste.book-your-tasting');
    }

    public function showChefsCorner()
    {
        return view('taste.chefs-corner');
    }

    public function showChefsCornerProfile()
    {
        return view('taste.chefs-corner-profile');        
    }

    public function showMixology()
    {
        return view('taste.mixology');
    }

    public function showGallery()
    {
        return view('taste.gallery');
    }

    public function showWineLoop()
    {
        return view('taste.wine-loop');
    }

    public function showWineLoopContact()
    {
        return view('taste.wine-contact');
    }
}
