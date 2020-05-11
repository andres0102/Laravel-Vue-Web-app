@extends('layouts.main-page')

@section('content')
    <fashion-page-spotlight inline-template
    :blog_articles="{{$blog_articles}}"
    :community_articles="{{$community_articles}}">
        <main>
            <slider :data="[{img: '{{ asset('assets/img/sliders/spotlight.png') }}', text: 'Spotlight On', class: 'explore-slider'}]">
            </slider>

            <section class="spotlight-page">
                <h2 class="blog-title">BLOG</h2>
                <section class="blog row m-0">
                    <div class="blog-card col-md-12 p-0 mb-4" v-for="article in page_blog_articles">
                        <div class="blog-wrapper">
                            <div class="col-md-5 image-header p-0">
                                <img :src='article.article_thumb' />
                            </div>
                            <div class="col-md-7 content">
                                <h2 class="blog-title mt-3">@{{article.article_header}}</h2>
                                <p class="blog-text">@{{article.article_desc}}</p>
                                <a class="blog-rm" :href="article.article_link">Read More...</a>
                                <p class="blog-breadcreambs mt-2 mb-0">Lorem ipsum / dolor sit amet / consectetur</p>
                            </div>
                        </div>
                    </div>
                    <div class="scoop-cards pr-0 ">
                        <h2 class="h2-title mb-3">COMMUNITY NEWS</h2>
                        <div class="row m-0 pl-1">
                                <div class="col-md-4 p-0 mb-3 pr-3 scoop-card" v-for="article in page_community_articles">
                                    <div class="scoop-wrapper">
                                        <div class="image-header">
                                            <img :src='article.article_thumb' />
                                        </div>
                                        <div class="content mt-3">
                                            <h2 class="scoop-title">@{{article.article_header}}</h2>
                                            <p class="scoop-text">@{{article.article_desc}}</p>
                                            <a class="scoop-rm" :href="article.article_link" >Read More...</a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </section>
            </section>
        </main>
    </fashion-page-spotlight>
@endsection
