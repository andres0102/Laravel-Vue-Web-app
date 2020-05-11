@extends('layouts.main-page')

@section('content')
    <fashion-talents-page inline-template
    :talents="{{$talents}}">
        <main>
            <slider :data="[{img: '{{ asset('assets/img/sliders/music.png') }}', text: 'Talents  and casting', class: 'explore-slider'}]">
            </slider>

            <section class="mt-4 wrapper">
                <div class="scoop-cards pr-0 mb-5">
                    <div class="product-selects w-100 mb-4 ml-1">
                        {{--<div>--}}
                            {{--<h2>Sort By: </h2>--}}
                            {{--<span>--}}
                                {{--<select>--}}
                                    {{--<option value="Select">GENRE</option>--}}
                                    {{--<option value="bar1">Bar 1</option>--}}
                                    {{--<option value="bar2">Bar 2</option>--}}
                                {{--</select>--}}
                            {{--</span>--}}
                        {{--</div>--}}
                    </div>
                    <div class="row m-0 pl-1 mt-2 mb-4" v-if="page_talents.length > 0">
                            <div class="col-md-4 p-0 mb-3 pr-3 scoop-card" v-for="talent in page_talents">
                                <div class="scoop-wrapper p-2">
                                    <div class="image-header">
                                        <img :src='talent.talent_thumb' />
                                    </div>
                                    <div class="content mt-3">
                                        <h2 class="scoop-title">@{{ talent.talent_name }}</h2>
                                        <p class="scoop-text">@{{talent.talent_desc}}</p>
                                        <a class="scoop-rm" :href="talent.talent_url">Read More...</a>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="load-more col-md-12 text-center mb-4" v-if="showLoading">
                        <a @click="loadMore()">LOAD MORE</a>
                    </div>
                </div>
            </section>
        </main>
    </fashion-talents-page>
@endsection
