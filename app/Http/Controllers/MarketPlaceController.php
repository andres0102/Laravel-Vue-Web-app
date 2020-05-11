<?php

namespace App\Http\Controllers;

use App\Mail\Mails;
use App\Models\Companies\Companies;
use App\Models\Products\CategoryToProduct;
use App\Models\Products\ProductsGalleryItems;
use App\Models\Products\ProductsReview;
use Illuminate\Http\Request;
use App\Models\Products\Products;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class MarketPlaceController extends Controller
{
    public function index()
    {   /*getting companies*/
        $companies = Companies::select('company_seo_url','company_thumb','company_name','company_short_desc')->limit(9)->get();
        $companyArray = [];
        $i=0;
        foreach ($companies as $company){
            $companyArray[$i]=array(
              'name'=>$company->company_name,
                'desc'=>$company->company_short_desc,
                'url'=>route('market-place-retails-page',['company_url'=>$company->company_seo_url]),
                'thumb'=>$company->transformThumb(),
            );
            $i++;
        }
        $companyTypes=Companies::getCompaniesTypes();

        return view('market-place.index',['companies'=>json_encode($companyArray),'companiesType'=>$companyTypes]);
    }
    /*
     * gettign companies more on load more
     * $param int $page - page of loading
     * */
    public function loadMoreCompanies($page=0,Request $request){
        if($page < 0){
            return response()->json([
                'status' => 'error',
                'error' => 'invalid_page',
                'msg' => 'Invalid Page'
            ], 400);
        }
        $sort = false;
        if($request->get('sort') != 'false'){
            $sort = "asc";
        }
        $filter = ['company_type','>',0];
        if($request->get('filter') != 'false'){
            $filter = ['company_type','=',$request->get('filter')];
        }
        if($sort) {
            $companies = Companies::select('company_seo_url', 'company_thumb', 'company_name', 'company_short_desc')->where([$filter])->orderBy('company_name', $sort)->limit(9)->offset($page * 9)->get();
        }else{
            $companies = Companies::select('company_seo_url', 'company_thumb', 'company_name', 'company_short_desc')->where([$filter])->orderBy('id','ASC')->limit(9)->offset($page * 9)->get();
        }
        $companyArray = [];
        foreach ($companies as $company){
            $companyArray[]=array(
                'name'=>$company->company_name,
                'desc'=>$company->company_short_desc,
                'url'=>route('market-place-retails-page',['company_url'=>$company->company_seo_url]),
                'thumb'=>$company->transformThumb(),
            );
        }
        return response()->json([
            'status' => 'success',
            'msg' => 'Success get',
            'companies'=>$companyArray,
            'sort'=>$sort,
            'filter'=>$filter,
        ], 200);


    }
    /**
     * show company by it's url
     * @param string $company_url - company seo url
     * @return html*/
    public function showRetails($company_url)
    {
        $company =  Companies::where('company_seo_url',$company_url)->first();
        if(!$company){
            return abort(404);
        }
        /*
         * products fro showgin on main page of retail*/
        $productsOnMain = $company->getCompanyProducts();
        return view('market-place.retails-business',['company'=>$company,'products'=>$productsOnMain]);
    }
    /*
     * loading more products
     * @param int $company_id - id of company
     * @param int $page - page for products to load
     * @return array */
    public function loadMoreProducts($company_id, $page=0,Request $request){
        $products = [];
        $company = Companies::find($company_id);
        if(!$company){
            return  response()->json([
                'status' => 'error',
                'msg' => 'Success products',
                'error' => 'invalid_credentials',
            ], 400);

        }
        if($request->get("category") == 'false'){

            $productsDb = Products::where('company_id',$company_id)->limit(9)->offset($page*9)->get();
        }else{
            $productsIdDb = CategoryToProduct::where('category_id',$request->get('category'))->get();
            $productsIdArray = [];
            foreach ($productsIdDb as $item) {
                $productsIdArray[]=$item->product_id;
            }
            if($company_id != 0)
                $productsDb  = Products::where('company_id','=',$company_id)->whereIn('id',$productsIdArray)->get();
            else
                $productsDb  = Products::whereIn('id',$productsIdArray)->get();
        }
        foreach ($productsDb as $product) {
            $products[]=array(
                'name'=>$product->name,
                'simple_desc'=>$product->simple_desc,
                'rating'=>$product->getRating()['rating'],
                'thumb'=>$product->transformThumb(),
                'price'=>$product->price,
                'url'=>route('market-place-per-product-page',['product_url'=> $product->seo_url]),
            );
        }
        return  response()->json([
            'status' => 'success',
            'msg' => 'Success products',
            'products'=>$products,
            'filter'=>$request->get("category"),
        ], 200);

    }
    /*
     * show products */
    public function showProducts($company_url, Request $request)
    {
        $count = 9;
        /*finding companyfrom url*/
        $company = Companies::select('company_name','id','company_thumb')->where('company_seo_url',$company_url)->first();
        /*
         * getting product of company*/
        $products = [];
        $categories = [];
        $company_id = 0;
        if($company) {
            $productsDb = Products::where('company_id',$company->id)->take($count)->get();
            foreach($productsDb as $product){
                $products[]=array(
                    'name'=>$product->name,
                    'simple_desc'=>$product->simple_desc,
                    'rating'=>$product->getRating()['rating'],
                    'thumb'=>$product->transformThumb(),
                    'price'=>$product->price,
                    'url'=>route('market-place-per-product-page',['product_url'=> $product->seo_url]),
                );
            }
            $categories = $company->getCompanyCategories();
        }else{
            return abort(404);
        }

        return view('market-place.product-page',['products'=>json_encode($products),'company_url'=>$company_url,'categories'=>$categories,'company'=>$company]);
    }

    public function showProduct( $product_url)
    {
        /*
         * getting product model*/
        $product =Products::where('seo_url',$product_url)->first();
        if(!$product){
            return abort(404);

        }
        /*getting company_model*/
        $company = Companies::find($product->company_id);

        /*
         * gettin full product info
         * */
        $productInfo = $product->getProductInfo();
        /*getting user info */
        $user = JWTAuth::user();
        $user_name = '';
        /*for displaying rating */
        $rating_exists = false;
        if($user){
            $user_name = $user->first_name.' '.$user->last_name;
            $review  = ProductsReview::where([['user_id',$user->id],['product_id',$product->id]])->first();
            if(!$review){
                $rating_exists = true;
            }
        }
        $rating = $product->getRating();

        /*getting product featured */
        $featured = $product->getFeatured();
        $featuredProducts = [];
        if(!empty($featured)){
            foreach($featured as $oneFeature) {

                $featuredProduct = Products::find($oneFeature['product_id']);
                $featuredProducts   [] = array(
                    'product_id' => $featuredProduct->id,
                    'thumb' => $featuredProduct->thumb_url,
                    'name' => $featuredProduct->name,
                    'simple_desc' => $featuredProduct->simple_desc,
                    'price' => $featuredProduct->price,
                    'url' => route('market-place-per-product-page', ['product_url' => $featuredProduct->seo_url]),
                    'rating'=>$featuredProduct->getRating()['rating'],
                    'category'=> $featuredProduct->getCategory(),
                );
            }

        }
        /*
         * getting product gallery info
         * */
        $productGallery = ProductsGalleryItems::where('product_id',$product->id)->orderBy('sort_order','DESC')->get();

        return view('market-place.per-product',
            [
                'product_info' => $productInfo,
                'user_name'=>$user_name,
                'rating_exists'=>$rating_exists,
                'rating'=>$rating,
                'featured'=>$featuredProducts,
                'galleryItems'=>$productGallery,
                'company'=>$company,
            ]);
    }

    public function sendQuestion(Request $request){
        $client = JWTAuth::user();
        $product_id = $request->get('product_id');
        if(!$client){
            return response()->json([
                'status' => 'error',
                'error' => 'invalid_credentials',
                'msg' => 'Invalid Credentials'
            ], 400);
        }
        $this->validate($request, [
            'text' => 'required',
            'email'=> 'required',
        ]);
        /*checking for star existing */
        $review  = ProductsReview::where([['user_id',$client->id],['product_id',$product_id]])->first();
        if(!$review){
            ProductsReview::create([
                'user_id'=>$client->id,
                'product_id'=>$product_id,
                'rating	'=>$request->get('rating')
            ]);
        }
        /*sending email*/
        $objMail= new \stdClass();
        $objMail->text = $request->get('text');
        $objMail->senderEmail = $request->get('email');
        $objMail->sender = $request->get("name");

        /*getting product info  for email */
        $product =Products::find($product_id);
        $objMail->productName = $product->name;
        $company = Companies::find($product->company_id);

        $objMail->productUrl =route('market-place-per-product-page', ['product_url' => $product->seo_url]);
        Mail::to("olsovka@gmail.com")->send(new Mails($objMail));
        return response()->json(['success' => 'success','text'=>'Question was sent!'], 200);
    }


}
