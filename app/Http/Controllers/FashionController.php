<?php

namespace App\Http\Controllers;

use App\Models\Blog\BlogArticles;
use App\Models\Blog\BlogCategories;
use App\Models\Companies\Companies;
use App\Models\Products\CategoryToProduct;
use App\Models\Products\ProductCategory;
use App\Models\Products\Products;
use App\Models\Talents\Talents;
use Illuminate\Http\Request;

class FashionController extends Controller
{

    /*
     * page category id
     * */
    const CATEGORY_ID = 6;
    /**
     * getting fashion main page it's categories ts
     * @return html
     */
    public function index()
    {
        /*getting product caategories in fashion page*/
        $categories_id_in_fashion = ProductCategory::getCategoriesForSite(self::CATEGORY_ID);
        $categories = [];

        foreach ($categories_id_in_fashion as $category_id){
            $category_info = ProductCategory::findOrFail($category_id);
            $categories[]=array(
                'can_name'=>$category_info->name,
                'cat_link'=>route('fashion-display-products-page',['category_url'=>$category_info->seo_url]),
                'sort_order'=>$category_info->sort_order,
            );
        }

        usort($categories,function($a, $b) {
        return $a['sort_order'] - $b['sort_order'];
        });
        /*getting customers favorites
        */
        $productsDb = Products::where([['sites_categories','LIKE',self::CATEGORY_ID]])->orderBy('sales','DESC')->limit(3)->get();
        $products = [];
        foreach($productsDb as $product){
            $product_info = Products::find($product->id);
            $products[]=array(
                'thumb'=>$product_info->transformThumb(),
                'url'=>route('market-place-per-product-page',['product_url'=> $product_info->seo_url]),
            );
        }
        return view('fashion.index',['categories'=>$categories,'products'=>$products]);
    }

    public function showMustHaves()
    {
        return view('fashion.must-haves');
    }
    /*
    * show products */
    public function showProducts($category_url, Request $request)
    {
        $count = 9;
        /*finding category*/
        $category = ProductCategory::where('seo_url',$category_url)->first();
        /*
         * getting product of company*/
        $products = [];
        if($category) {
            $productsDb = CategoryToProduct::where('category_id',$category->id)->limit(9)->get();
            foreach($productsDb as $product){
                $product_info = Products::findOrFail($product->product_id);
                $company = Companies::find($product_info->company_id);
                $products[]=array(
                    'name'=>$product_info->name,
                    'simple_desc'=>$product_info->simple_desc,
                    'rating'=>$product_info->getRating()['rating'],
                    'thumb'=>$product_info->transformThumb(),
                    'price'=>$product_info->price,
                    'url'=>route('market-place-per-product-page',['product_url'=> $product_info->seo_url]),
                );
            }
        }else{
            return abort(404);
        }
        return view('fashion.product-page',['products'=>json_encode($products),'category'=>$category]);
    }
    /**
     * show products for diff pages
     * @return html
     */
    public function showSortProducts($sort, Request $request){
        $products = [];
        $page = 'fashion.product-page';
        switch ($sort){
            case 'new-arrivals':
                $productsDb = Products::where([['sites_categories','LIKE',self::CATEGORY_ID]])->orderBy('created_at','DESC')->limit(9)->get();
                foreach ( $productsDb as $product) {
                    $products[]=array(
                        'name'=>$product->name,
                        'simple_desc'=>$product->simple_desc,
                        'rating'=>$product->getRating()['rating'],
                        'thumb'=>$product->transformThumb(),
                        'price'=>$product->price,
                        'url'=>route('market-place-per-product-page',['product_url'=> $product->seo_url]),
                    );
                }
                break;
            case 'must-have':
                $productsDb = Products::getFashionMustHave();
                    foreach ( $productsDb as $productDb) {
                        $product = Products::find($productDb->product_id);
                        $products[]=array(
                            'name'=>$product->name,
                            'simple_desc'=>$product->simple_desc,
                            'rating'=>$product->getRating()['rating'],
                            'thumb'=>$product->transformThumb(),
                            'price'=>$product->price,
                            'url'=>route('market-place-per-product-page',['product_url'=> $product->seo_url]),
                        );
                    }
                $page ='fashion.must-haves';
                break;
            case 'exclusive':
                $productsDb = Products::getFashionExclusive();
                foreach ( $productsDb as $productDb) {
                    $product = Products::find($productDb->product_id);
                    $products[]=array(
                        'name'=>$product->name,
                        'simple_desc'=>$product->simple_desc,
                        'rating'=>$product->getRating()['rating'],
                        'thumb'=>$product->transformThumb(),
                        'price'=>$product->price,
                        'url'=>route('market-place-per-product-page',['product_url'=> $product->seo_url]),
                    );
                }
                break;
            default:
                return abort(404);
                break;
        }


        return view($page,['products'=>json_encode($products),'category'=>false,'type'=>$sort]);
    }
    /**
     * sorting products
     * @param Request $request - get request
     * @return json array
     * */
    public function sortProducts(Request $request){
        $sort = $request->get('sort');
        $category_id = $request->get('category_id');
        $limit = 9;
        $category = ProductCategory::find($category_id);
        $products = [];
        /*getting products if category*/
        if($category){
            $productsDb = CategoryToProduct::where('category_id',$category_id)->limit(9)->get();
            foreach ($productsDb as $product) {
                $productInfo = Products::find($product->product_id);
                $company = Companies::find($productInfo->company_id);
                $products[]=array(
                    'name'=>$productInfo->name,
                    'simple_desc'=>$productInfo->simple_desc,
                    'rating'=>$productInfo->getRating()['rating'],
                    'thumb'=>$productInfo->transformThumb(),
                    'price'=>$productInfo->price,
                    'url'=>route('market-place-per-product-page',['product_url'=> $productInfo->seo_url]),
                );
            }

        }
        /*getting products if type*/
        if($request->get('type')){
            switch ($request->get('type')){
                case 'new-arrivals':
                    $productsDb = Products::where([['sites_categories','LIKE',self::CATEGORY_ID]])->orderBy('created_at','DESC')->limit(9)->get();
                    foreach ( $productsDb as $product) {
                        $products[]=array(
                            'name'=>$product->name,
                            'simple_desc'=>$product->simple_desc,
                            'rating'=>$product->getRating()['rating'],
                            'thumb'=>$product->transformThumb(),
                            'price'=>$product->price,
                            'url'=>route('market-place-per-product-page',['product_url'=> $product->seo_url]),
                        );
                    }
                    break;
                case 'must-have':
                    $productsDb = Products::getFashionMustHave();
                    foreach ( $productsDb as $productDb) {
                        $product = Products::find($productDb->product_id);
                        $products[]=array(
                            'name'=>$product->name,
                            'simple_desc'=>$product->simple_desc,
                            'rating'=>$product->getRating()['rating'],
                            'thumb'=>$product->transformThumb(),
                            'price'=>$product->price,
                            'url'=>route('market-place-per-product-page',['product_url'=> $product->seo_url]),
                        );
                    }
                    $page ='fashion.must-haves';
                    break;
                case 'exclusive':
                    $productsDb = Products::getFashionExclusive();
                    foreach ( $productsDb as $productDb) {
                        $product = Products::find($productDb->product_id);
                        $products[]=array(
                            'name'=>$product->name,
                            'simple_desc'=>$product->simple_desc,
                            'rating'=>$product->getRating()['rating'],
                            'thumb'=>$product->transformThumb(),
                            'price'=>$product->price,
                            'url'=>route('market-place-per-product-page',['product_url'=> $product->seo_url]),
                        );
                    }
                    break;
                default:
                    break;
            }
        }
        if($request->get("sort")){

            switch ($request->get('sort')){
                case "rating":
                    usort($products, function($a,$b){
                        return $a['rating'] < $b['rating'];
                    });
                    break;
                case 'price':
                    usort($products, function($a,$b){
                        return $a['price'] > $b['price'];
                    });
                    break;
                case 'name':
                    usort($products, function($a,$b){
                        return strcmp($a["name"], $b["name"]);
                    });
                default:
                    break;

            }
            return  response()->json([
                'status' => 'success',
                'msg' => 'Success products',
                'products'=>$products,
            ], 200);
        }else{
            return  response()->json([
                'status' => 'error',
                'msg' => 'Wrong  sort',
                'error' => 'invalid_sort',
            ], 400);

        }
    }
    public function moreProducts($type, $page, Request $request){
        $products = [];
        $productsDb = [];
        switch ($type){
            case 'new-arrivals':
                $productsDb = Products::where([['sites_categories','LIKE',self::CATEGORY_ID]])->orderBy('created_at','DESC')->limit(9)->offset($page*(int)9)->get();
                foreach ( $productsDb as $product) {
                    $products[]=array(
                        'name'=>$product->name,
                        'simple_desc'=>$product->simple_desc,
                        'rating'=>$product->getRating()['rating'],
                        'thumb'=>$product->transformThumb(),
                        'price'=>$product->price,
                        'url'=>route('market-place-per-product-page',['product_url'=> $product->seo_url]),
                    );
                }
                break;
            case 'must-have':
                $productsDb = Products::getFashionMustHave($page);
                foreach ( $productsDb as $productDb) {
                    $product = Products::find($productDb->product_id);
                    $products[]=array(
                        'name'=>$product->name,
                        'simple_desc'=>$product->simple_desc,
                        'rating'=>$product->getRating()['rating'],
                        'thumb'=>$product->transformThumb(),
                        'price'=>$product->price,
                        'url'=>route('market-place-per-product-page',['product_url'=> $product->seo_url]),
                    );
                }
                $page ='fashion.must-haves';
                break;
            case 'exclusive':
                $productsDb = Products::getFashionExclusive($page);
                foreach ( $productsDb as $productDb) {
                    $product = Products::find($productDb->product_id);
                    $products[]=array(
                        'name'=>$product->name,
                        'simple_desc'=>$product->simple_desc,
                        'rating'=>$product->getRating()['rating'],
                        'thumb'=>$product->transformThumb(),
                        'price'=>$product->price,
                        'url'=>route('market-place-per-product-page',['product_url'=> $product->seo_url]),
                    );
                }
                break;
            default:
                break;
        }

        switch ($request->get('sort')){
            case "rating":
                usort($products, function($a,$b){
                    return $a['rating'] < $b['rating'];
                });
                break;
            case 'price':
                usort($products, function($a,$b){
                    return $a['price'] > $b['price'];
                });
                break;
            case 'name':
                usort($products, function($a,$b){
                    return strcmp($a["name"], $b["name"]);
                });
            default:
                break;

        }
        return  response()->json([
            'status' => 'success',
            'msg' => 'Success products',
            'products'=>$products,
        ], 200);
    }

    public function designerHouseShow()
    {

        return view('fashion.designer-house');
    }

    public function designerLocalHouseShow()
    {
        $companies = [];

        foreach (Companies::getCompaniesFromSitecategory(self::CATEGORY_ID) as $one_company){
            $company_info = Companies::find($one_company->company_id);
            $companies[]=array(
                'name'=>$company_info->company_name,
                'url'=>route('market-place-retails-page',['company_url'=>$company_info->company_seo_url]),
                'thumb'=>$company_info->transformThumb(),
            );
        }
        return view('fashion.local-designer-house',['companies'=>json_encode($companies)]);
    }
    /**
     * show fashion editorials and fashion scoop news
     * @return html */
    public function showHautreCoutre()
    {
        /*getting blog info */
        $fashion_ed_info = BlogCategories::find(3);
        /*
         * getting blog articles
         * */
        $fashion_ed_articles =  [];
        $fashion_ed_db = BlogArticles::where('blog_cat_id',$fashion_ed_info->id)->limit($fashion_ed_info->limit_on_page)->get();
        if($fashion_ed_db)
            foreach ($fashion_ed_db as $article) {

                $fashion_ed_articles[]=array(
                    'article_header'=>$article->article_header,
                    'article_thumb' => $article->transformThumb(),
                    'article_desc' => substr($article->article_text,0,$fashion_ed_info->preview_length).'...',
                    'article_link' => route('fashion-blog-article-page',['article_url'=>$article->article_seo_url]),
                );
            }
        /*
         * getting community articles
        */
        $fashion_scoop_info = BlogCategories::find(4);
        $fashion_scoop_articles = [];
        $articles_in_db =  BlogArticles::where('blog_cat_id',$fashion_scoop_info->id)->limit($fashion_scoop_info->limit_on_page)->get();
        if($articles_in_db)
            foreach ($articles_in_db as $article) {

                $fashion_scoop_articles[]=array(
                    'article_header'=>$article->article_header,
                    'article_thumb' => $article->transformThumb(),
                    'article_desc' => substr($article->article_text,0,$fashion_scoop_info->preview_length).'...',
                    'article_link' => route('fashion-blog-article-page',['article_url'=>$article->article_seo_url]),
                );
            }
        /*
         * getting 4 tallents
        */
        $talents = [];
        $talents_in_db = Talents::where('site_category_id',self::CATEGORY_ID)->limit(4)->get();
        if($talents_in_db)
            foreach ($talents_in_db as $talent){
                $talents[] = array(
                  'talent_name'=>$talent->talent_name,
                    'talent_thumb' =>$talent->transformThumb(),
                );
            }
        return view('fashion.hautre-coutre',['fashion_ed_articles'=>json_encode($fashion_ed_articles), 'fashion_scoop_articles'=>json_encode($fashion_scoop_articles),'talents'=>json_encode($talents)]);
    }

    /**
     * show blog and community news
     * @return html */
    public function showSpotlightOn()
    {
        /*getting blog info */
        $blog_info = BlogCategories::find(1);
        /*
         * getting blog articles
         * */
        $blog_articles =  [];
        $articles_in_db = BlogArticles::where('blog_cat_id',$blog_info->id)->limit($blog_info->limit_on_page)->get();
        if($articles_in_db)
            foreach ($articles_in_db as $article) {

                $blog_articles[]=array(
                    'article_header'=>$article->article_header,
                    'article_thumb' => $article->transformThumb(),
                    'article_desc' => substr($article->article_text,0,$blog_info->preview_length).'...',
                    'article_link' => route('fashion-blog-article-page',['article_url'=>$article->article_seo_url]),
                );
            }
        /*
         * getting community articles
        */
        $community_blog_info = BlogCategories::find(2);
        $community_articles = [];
        $articles_in_db =  BlogArticles::where('blog_cat_id',$community_blog_info->id)->limit($community_blog_info->limit_on_page)->get();
        if($articles_in_db)
            foreach ($articles_in_db as $article) {

                $community_articles[]=array(
                    'article_header'=>$article->article_header,
                    'article_thumb' => $article->transformThumb(),
                    'article_desc' => substr($article->article_text,0,$community_blog_info->preview_length).'...',
                    'article_link' => route('fashion-blog-article-page',['article_url'=>$article->article_seo_url]),
            );
            }

        return view('fashion.spotlight-on',['blog_articles'=>json_encode($blog_articles), 'community_articles'=>json_encode($community_articles)]);
    }
    /**
     * showing talents list
     * @return html
     */
    public function showTalents(){
        /*getting list of 6 tallents */
        $limit = 6;
        $talents_db = Talents::where("site_category_id",self::CATEGORY_ID)->limit($limit)->get();
        $talents  = [];
        if($talents_db)
            foreach ($talents_db as $talent){
                $talents[]=array(
                    'talent_name'=>$talent->talent_name,
                    'talent_thumb' =>$talent->transformThumb(),
                    'talent_url'=>route('fashion-display-one-talent-page',['talent_url'=>$talent->talent_seo_url]),
                    'talent_desc'=>substr($talent->talent_desc,0,100).'...',
                );
            }

        return view('fashion.talent-list',['talents'=>json_encode($talents)]);
    }
    /**
     * show one talent
     * @param string $talent_url - seo url of talent
     * @return html
     */
    public function showOneTalent($talent_url){
        $talent = Talents::where('talent_seo_url',$talent_url)->first();
        if(!$talent)
            return abort(404);
        return view('fashion.talent',['talent'=>$talent]);


    }
    /**
     * load more tallents but clicking button load more on talent page
     * @param Request $request - get request
     * @return json array
    */
    public function loadMoreTalents(Request $request){
        $limit = 6;
        $page = $request->get('page');
        $talents_db = Talents::where("site_category_id",self::CATEGORY_ID)->limit($limit)->offset($page*(int)$limit)->get();
        $talents  = [];
        if($talents_db)
            foreach ($talents_db as $talent){
                $talents[]=array(
                    'talent_name'=>$talent->talent_name,
                    'talent_thumb' =>$talent->transformThumb(),
                    'talent_url'=>route('fashion-display-one-talent-page',['talent_url'=>$talent->talent_seo_url]),
                    'talent_desc'=>substr($talent->talent_desc,0,100).'...',
                );
            }
        return  response()->json([
            'status' => 'success',
            'msg' => 'talent list',
            'talents' => $talents,
        ], 200);
    }

}
