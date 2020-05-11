<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'bag'], function ($router) {
    Route::post('add-to-bag', 'Checkout\BagController@addProductToBag')->name('add-to-bag');
    Route::post('check-bag','Checkout\BagController@checkBag')->name('check-bag');
    Route::post('update-bag','Checkout\BagController@updateBagItem')->name('update-bag');
    Route::post('payment','Checkout\BagController@sendPayment')->name('send-payment');

});
/*working with wishlists*/
Route::group(['prefix' => 'wishlist'], function ($router) {
    Route::get('check/{product_id}', 'User\WishlistController@checkInWishList')->name('wish-check');
    Route::post('add/{product_id}','User\WishlistController@addToWishList')->name('add-wish');
    Route::post('remove/{wishlist_id}','User\WishlistController@removeFromWishList')->name('remove-one-wish');
    Route::get('get','User\WishlistController@index')->name('get-wish');
});
//woking with products
Route::group(['prefix'=> 'marketplace'],function($router){
    Route::post('question','MarketPlaceController@sendQuestion')->name('send-question');
});

/*working with explore*/
Route::group(['prefix'=>'explore'],function($router){
    Route::get('filter','ExploreController@filter')->name('filter-explore');
});
/*
 * working with companies
 */
Route::group(['prefix'=>'companies'],function($router){
 Route::get('more/{page}','MarketPlaceController@loadMoreCompanies')->name('more-companies');
 Route::get('morep/{company_id}/{page}','MarketPlaceController@loadMoreProducts')->name('more-products');
});

/*
 * working with fashion
 */
Route::group(['prefix'=>'fashion'],function($router){
    Route::get('morep/{category_id}/{page}','FashionController@loadMoreProducts')->name('fashion-                           more-products');
    Route::get('products/sort','FashionController@sortProducts')->name('fashion-sort-products');
    Route::get("more-talents",'FashionController@loadMoreTalents')->name('fashion-talents-more');
});

/*
 * working with taste
 */
Route::group(['prefix'=>'taste'],function($router){
    /*filter items*/
    Route::get("filter",'TasteController@filterCompanies')->name('taste-filter-companies');
    Route::get('search','TasteController@searchCompanies')->name("taste-search-companies");
});
