@extends('layouts.main-page')

@section('content')
    <market-place-retail-page inline-template>
        <main>
            <slider :data="[{img: '{{ $company->transformThumb() }}', text: '', class: 'explore-slider'}]">
            </slider>

            <section class="profile-page">
                <div class="row m-0">
                    <div class="header w-100">
                        <div>
                            <h2 class="title">{{$company->company_name}}</h2>
                        </div>
                        <div>
                        <a href="{{ route('market-place-product-page',['company_url'=>$company->company_seo_url])}}" class="black-btn font-20px">Visit My Online Store!</a>
                        </div>
                    </div>
                    <div class="description col-md-8 col-sm-12 mb-4 p-0">
                        <div class="main-text">
                            <h2>Business Description</h2>
                            <p>
                              {{$company->company_desc}}
                            </p>
                        </div>
                    </div>
                    <div class="info col-md-4 col-sm-12">
                        <div class="info-block">
                            <div class="info-title">Contact Details</div>
                            <div class="col-md-12 col-sm-12 info-details">
                                @if ($company->company_place)
                                <div class="row pt-0 pb-0">
                                    <div class="col-md-1">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <div class="col-md-11">
                                        {{$company->company_place}}
                                    </div>     
                                </div>
                                @endif
                                @if ($company->company_opened)
                                <div class="row pt-0 pb-0">
                                    <div class="col-md-1">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <div class="col-md-11">
                                        {{$company->company_opened}}
                                    </div>     
                                </div>
                                @endif
                                @if($company->company_phone)
                                <div class="row pt-0 pb-0">
                                    <div class="col-md-1">
                                        <i class="fa fa-phone"></i> 
                                    </div>
                                    <div class="col-md-11">
                                        {{$company->company_phone}}
                                    </div> 
                                </div>
                                @endif
                                @if ($company->company_web)
                                <div class="row pt-0 pb-0">
                                    <div class="col-md-1">
                                        <i class="fa fa-dribbble"></i>
                                    </div>
                                    <div class="col-md-11">
                                         {{$company->company_web}}
                                    </div> 
                                </div>
                                @endif
                            </div>
                            <div class="info-title mt-2">Social Media</div> 
                            <div class="col-md-12 col-sm-12 info-social mb-0 p-0">
                                @if ($company->company_fb)
                            <a class="social-link" target="_blank" href="{{$company->company_fb}}"><div class="w-100 mt-3 facebook text-center "><i class="fa fa-facebook"></i></div></a>
                                @endif
                                @if ($company->company_ytb)
                                <a class="social-link" target="_blank" href="{{$company->company_ytb}}"><div class="w-100 mt-2 twitter text-center"><i class="fa fa-twitter"></i></div></a>
                                    @endif
                                    @if($company->company_twt)
                                <a class="social-link"  target="_blank" href="{{$company->company_twt}}"><div class="w-100 mt-2 mb-3 youtube text-center"><i class="fa fa-youtube"></i></div></a>
                                        @endif
                            </div>                          
                        </div>
                    </div>
                </div>
            </section>
            @if($products)
            <section class="designer-product mt-4 w-100">
                <div class="row m-0">
                    @foreach ($products as $product)
                        <div class="col-md-3 designer-card mb-4 p-0 pr-3">
                            <div class="designer-wrapper">
                                <a href="{{ route('market-place-per-product-page',['company_url'=>$company->company_seo_url,'product_url'=>$product->seo_url]) }}">
                                    <div class="image-header">
                                        <img src="{{$product->transformThumb()}}" />
                                    </div>
                                    <div class="content">
                                        <h2 class="text-black">{{$product->name}}</h2>
                                        <div class="category">{{$product->getCategory()}}</div>
                                        <div class="footer">
                                            <div class="star-ratings-css mb-2">
                                                <div class="star-ratings-css-top" style="width: {{$product->getRating()['rating'] * 10}}%">
                                                    <span>★</span>
                                                    <span>★</span>
                                                    <span>★</span>
                                                    <span>★</span>
                                                    <span>★</span>
                                                </div>
                                                <div class="star-ratings-css-bottom">
                                                    <span>★</span>
                                                    <span>★</span>
                                                    <span>★</span>
                                                    <span>★</span>
                                                    <span>★</span>
                                                </div>
                                            </div>
                                            <span class="price">${{$product->price}}</span>
                                        </div>                                                                    
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                </div>
            </section>
            @endif

             <!-- EVENTS -->
             <events-widget></events-widget>
        </main>
    </market-place-retail-page>
@endsection
