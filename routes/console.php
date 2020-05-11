<?php

use App\Models\Blog\BlogArticles;
use App\Models\Blog\BlogCategories;
use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');
/*generate rss
*/
Artisan::command('generate:feed', function () {
    $this->info("Generating All articles RSS Feed");
    /*get blog posts */
    /*getting blog info */
    /*
     * getting all articles
     * */
    $articles = BlogArticles::latest()->get();
    $site=array(
        'title'=> 'All Articles',
        'link'=> 'http://franceloop.com/',
        'descr'=>' All Francellop articles',
    );
    $rssFileContents = view('fashion.rss.blog-rss', compact('articles','site'));
    Storage::disk('rss_main')->put('rss.xml', $rssFileContents);
    $this->info("Completed all rss");
    $this->info("Generating Spotlight on Feed");
    /*get articles in spotlight */
    $categoriesDb  = BlogCategories::where('blog_type',0)->get();
    $categoriesId = [];
    foreach ($categoriesDb as $category){
        $categoriesId[] = $category->id;
    }
    $articles = BlogArticles::whereIn('blog_cat_id',$categoriesId)->latest()->get();
    $site=array(
        'title'=> 'Spotlight On Articles',
        'link'=> 'http://franceloop.com/spotlight-on',
        'descr'=>'Spotlight on Francellop articles',
    );
    $rssFileContents = view('fashion.rss.blog-rss', compact('articles','site'));
    Storage::disk('rss_feeds')->put('spotlight.xml', $rssFileContents);
    $this->info("Completed Spotlight rss");
    $this->info("Generating Haute Couture on Feed");
    /*
     * getting articles in haute
     * */
    $categoriesDb  = BlogCategories::where('blog_type',1)->get();
    $categoriesId = [];
    foreach ($categoriesDb as $category){
        $categoriesId[] = $category->id;
    }
    $articles = BlogArticles::whereIn('blog_cat_id',$categoriesId)->latest()->get();
    $site=array(
        'title'=> 'Haute Couture  Articles',
        'link'=> 'http://franceloop.com/fashion/haute-coutre',
        'descr'=>'Haute Couture Francellop articles',
    );
    $rssFileContents = view('fashion.rss.blog-rss', compact('articles','site'));
    Storage::disk('rss_feeds')->put('haute.xml', $rssFileContents);
    $this->info("Completed Haute Couture rss");

});
