@extends('layouts.main-page')

@section('content')
    <fashion-haute-page inline-template
    :fashion_ed_articles="{{$fashion_ed_articles}}"
    :fashion_scoop_articles="{{$fashion_scoop_articles}}"
    :talents="{{$talents}}">
        <main>
            <slider :data="[{img: '{{ asset('assets/img/sliders/hautre.png') }}', text: 'Haute Couture', class: 'explore-slider'}]">
            </slider>

            <section class="haute-main mt-4">
                <div class="row m-0 p-0">
                    <div class="col-md-8 houte-cards p-0">
                        <h2 class="h2-title mb-3">FASHION EDITORIALS</h2>
                            <div class="col-md-12 houte-card mb-3 p-0" v-for="article in page_fash_edit">
                                <div class="houte-wrapper">
                                    <div class="image-header">
                                        <img :src='article.article_thumb' />
                                    </div>
                                    <div class="content">
                                        <p class="breadcreambs">Lorem ipsum / dolor sit amet / consectetur</p>
                                        <h2 class="houte-title">@{{ article.article_header }}</h2>
                                        <p class="houte-text">@{{ article.article_desc }}</p>
                                        <a class="mt-3 houte-rm" :href="article.article_link">Read More...</a>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-md-4 scoop-cards pr-0">
                        <h2 class="h2-title mb-3">FASHION SCOOP</h2>
                            <div class="col-md-12 p-0 mb-3 scoop-card" v-for="article in page_fash_scoop">
                                <div class="scoop-wrapper">
                                    <div class="image-header">
                                        <img :src='article.article_thumb' />
                                    </div>
                                    <div class="content mt-3">
                                        <h2 class="scoop-title">@{{ article.article_header }}</h2>
                                        <p class="scoop-text">@{{ article.article_desc }}</p>
                                        <a class="scoop-rm" :href="article.article_link">Read More...</a>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </section>
            <section class="houte-talent-cards" v-if="page_talents.length > 0">
                <div class="talent-header mb-3 w-100">
                    <h2 class="h2-title">TALENT & CASTING</h2>
                    <a href="{{ route('fashion-display-talents-page') }}" class='black-btn'>View all Talent & Casting</a>
                </div>
                <div class="row p-0 m-0">
                        <div class="houte-talent-card col-md-3 pl-0 mb-3" v-for="talent in page_talents ">
                            <div class="houte-talent-wrapper">
                                <div class="image-header">
                                    <img :src='talent.talent_thumb' />
                                </div>
                                <div class="content">
                                    <h2 class="houte-talent-title">@{{ talent.talent_name }}</h2>
                                </div>
                            </div>
                        </div>
                </div>
            </section>

            <!-- EVENTS -->
            <events-widget></events-widget>
        </main>
    </fashion-haute-page>
@endsection
