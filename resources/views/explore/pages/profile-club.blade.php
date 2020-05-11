@extends('layouts.main-page')

@section('content')
    <explore-profile-page inline-template>
        <main class="adventure-profile-page">
            <slider :data="[{img: '{{$client->transformThumb()}}', text: '{{$client->cl_name}}', class: 'explore-slider'}]">
            </slider>

            <section class="profile-page">
                <div class="row">
                    <div class="description col-md-8 col-sm-12 mb-4">
                        <h2 class="title">{{$client->cl_name}}</h2>
                        <div class="main-text">
                            <h2>Business Description</h2>
                            <p>
                                {{$client->cl_desc}}
                            </p>
                        </div>
                    </div>
                    <div class="events col-md-4 col-sm-12">
                        <events-right-widget></events-right-widget>

                    </div>
                </div>
            </section>
            @if (!empty($services))
                <section id="services" class="our-services">
                    <h2>Our Services</h2>
                    <div class="m-0">
                        <carousel :responsive="{0:{items:1,nav:false},600:{items:3,nav:false}}" :dots="true" :autoWidth="true" style="margin:0 auto">
                            @foreach ($services as $service )

                                <div class="service-card  pr-1 pl-1">
                                    <div class="service-wrapper">
                                        <img src='{{$service['thumb']}}' />
                                        <span class="text">{{$service['name']}}</span>
                                    </div>
                                </div>
                            @endforeach
                        </carousel>
                    </div>

                </section>
            @endif
            @if (!empty($gallery))
                <section class="our-services mb-4">
                    <h2>Image Gallery</h2>
                    <div class="row m-0">
                            @foreach ($gallery as $galleryItem)
                                <div class="service-card col-md-4 col-sm-12 mb-2 pr-1 pl-1">
                                    <div class="service-wrapper">
                                        <img src='{{$galleryItem['thumb']}}' />
                                    </div>
                                </div>
                            @endforeach
                    </div>
                </section>
            @endif

        </main>
    </explore-profile-page>
@endsection
