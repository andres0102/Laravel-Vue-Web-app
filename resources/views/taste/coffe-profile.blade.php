@extends('layouts.main-page')

@section('content')
    <profile-default-page inline-template>
        <main class="adventure-profile-page">
            <slider :data="[{img: '{{$company_thumb = 0 }}', text: '{{ $company_name = 0 }}', class: 'explore-slider'}]">
            </slider>

            <section class="profile-page">
                <div class="row">
                    <div class="description col-md-8 col-sm-12 mb-4">
                        <h2 class="title">{{ $company_name = 0 }}</h2>
                        <div class="main-text">
                            <h2>Business Description</h2>
                            <p>
                                {{ $company_desc = 0 }}
                            </p>
                        </div>
                    </div>
                    <div class="info col-md-4 col-sm-12">
                        <h2 class="title text-right">
                            <a class="" href="#"> </a>                        
                        </h2>

                        <div class="info-block">
                            <div class="info-title">Contact Details</div>
                            <div class="col-md-12 col-sm-12 info-details">
                                @if ($company_place = false)
                                <div class="row pt-0 pb-0">
                                    <div class="col-md-1">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <div class="col-md-11">
                                        {{ $company_place = 0}}
                                    </div>     
                                </div>
                                @endif
                                @if($company_opened = 0)
                                <div class="row pt-0 pb-0">
                                    <div class="col-md-1">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <div class="col-md-11">
                                        {{ $company_opened = 0 }}
                                    </div>     
                                </div>
                                @endif
                                @if($company_phone = 0)
                                <div class="row pt-0 pb-0">
                                    <div class="col-md-1">
                                        <i class="fa fa-phone"></i> 
                                    </div>
                                    <div class="col-md-11">
                                        {{ $company_phone = 0 }}
                                    </div> 
                                </div>
                                @endif
                                    @if($company_web = 0)
                                <div class="row pt-0 pb-0">
                                    <div class="col-md-1">
                                        <i class="fa fa-dribbble"></i>
                                    </div>
                                    <div class="col-md-11">
                                         {{ $company_web = 0 }}
                                    </div> 
                                </div>
                                    @endif
                            </div>
                            @if( $company_fb = 0 ||  $company_ytb = 0 ||  $company_twt = 0)
                                <div class="info-title mt-2">Social Media</div>
                                <div class="col-md-12 col-sm-12 info-social mb-0 p-0">
                                    @if ($company_fb = 0)
                                        <a href="{{ $company_fb = 0 }}">
                                            <div class="w-100 mt-3 facebook text-center "><i class="fa fa-facebook"></i></div>
                                        </a>
                                    @endif
                                    @if( $company_twt = 0)
                                        <a href="{{ $company_twt = 0 }}"><div class="w-100 mt-2 twitter text-center"><i class="fa fa-twitter"></i></div></a>
                                    @endif
                                    @if ( $company_ytb = 0)
                                        <a href="{{ $company_ytb = 0 }}">
                                            <div class="w-100 mt-2 mb-3 youtube text-center"><i class="fa fa-youtube"></i></div>
                                        </a>

                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
            <section id="services" class="our-services">
                <h2>Our Services</h2>
                <div class="m-0">
                    <carousel :responsive="{0:{items:1,nav:false},600:{items:3,nav:false}}" :dots="true" :autoWidth="true" style="margin:0 auto">
                        @foreach ($services = [] as $service )

                            <div class="service-card mb-4 pr-1 pl-1">
                                <div class="service-wrapper">
                                    <img src='{{$service['thumb']}}' />
                                    <span class="text">{{$service['name']}}</span>
                                </div>
                            </div>
                        @endforeach
                    </carousel>
                </div>
            </section>
            <section class="our-services mb-4">
                <h2>Image Gallery</h2>
                <div class="m-0">
                    <carousel  :responsive="{0:{items:1,nav:false},600:{items:3,nav:false},1000:{items:6,nav:false, dots:true}}" :dots="true" >
                    @foreach ($gallery = [] as $galleryItem)
                        <div class="service-card adventure-service-card  mb-2 pl-1 pr-1">
                            <div class="service-wrapper">
                                <img src='{{$galleryItem['thumb']}}' />
                            </div>
                        </div>
                    @endforeach
                    </carousel>
                </div>
            </section>
            <events-widget></events-widget>
        </main>
    </profile-default-page>
@endsection
