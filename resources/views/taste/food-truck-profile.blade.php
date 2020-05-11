@extends('layouts.main-page')

@section('content')
    <taste-page inline-template>
        <main>
            <slider :data="[{img: '{{$company_thumb = 0}}', text: '{{$company_name = 0}}', class: 'explore-slider'}]">
            </slider>

            <section class="profile-page music-show-page">
                <h2 class="title text-center">
                    @if ($company_book_url = false)
                    <a class="black-btn mr-5" href="{{ $company_book_url = 0 }}">Book Your Party</a>
                    @endif
                    @if ($company_cate_url = false)
                    <a class="black-btn ml-5" href="{{ $company_cate_url = 0}}">Let Us Cater For You!</a>
                    @endif
                </h2>
                <div class="row">
                    <div class="description col-md-8 col-sm-12 mb-4">
                        <div class="main-text">
                            <h2>Business Description</h2>
                            <p>
                                {{-- {{$company_desc = 0}} --}}
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempora illo eum, necessitatibus corrupti eveniet aut hic adipisci eaque minima animi esse, porro, magnam magni autem quae cum distinctio sint. Libero.
                            </p>
                            <div class="col-md-12 p-0 row m-0">
                                <div class="reserve-card col-md-6">
                                    <div class="reserve-wrapper">
                                        <img src="{{$chef_image = 0}}" />
                                    </div>
                                </div>
                                <div class="reserve-btns col-md-6 text-center align-items-center justify-content-center d-flex flex-column">
                                    @if ($chef_link = 0)
                                    <a class="black-btn w-100 d-block" href="{{$chef_link = 0 }}">Meet the Chef</a>
                                    @endif
                                    @if ($chef_menu_url = 0)
                                    <a class="black-btn w-100 mt-5 d-block" href="{{$chef_menu_url = 0}}">View Our Menu</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <h2 class="medium-title text-left font-barlow-bold mt-4 mb-4 text-black">Events for the Restaurant</h2>
                        <div class="row p-0 m-0">
                            @for($i = 1; $i < 4; $i++)
                                <div class="col-md-4 m-upcoming-event-card mb-4 p-0 pr-3">
                                    <div class="m-upcoming-event-wrapper">
                                        <div class="image-header">
                                            <img src="{{ asset('assets/img/music/' . $i . '.png') }}" />
                                        </div>
                                    
                                        <div class="content">
                                            <div class="header">
                                                <h2>Florence + the machine <span class="time">8PM</span></h2>
                                                <h3>Cold War Kids <span class="time">7PM</span></h3>                                            
                                            </div>
                                            <div class="footer">
                                                <div class="date">
                                                    <span class="text">
                                                        OCT 
                                                        <span>23</span>
                                                    </span>
                                                </div>
                                                <div class="description">
                                                    <p class="text">This event is 21 and over</p>
                                                    <a href="#"><div>+</div>More Info</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="right-side col-md-4 col-sm-12 p-0 m-0 pt-2 pl-4 mb-2">
                    <div class="col-md-12 p-0 m-0 main-col pb-2 mt-2 mb-4">
                            <div class="info-title mt-2">Make a Reservation Now</div> 
                            <div class="col-md-12 col-sm-12 row info-cards justify-content-center align-items-center m-0 mb-0 p-2 pt-2 pb-4">
                                <h2 class="reserv-title text-center mb-2ss">Reserve your dates now via:</h2>
                                <div class="justify-content-center align-items-center m-0">
                                    @if ($company_web = 0)
                                    <div class="justify-content-center align-items-center cursor-pointer row m-0">
                                        <div class="col-md-1 reserv-icon pr-3">
                                            <i class="fa fa-dribbble"></i>
                                        </div>
                                        <div class="col-md-10 reserv-text pl-3 text-center">
                                            <a href="{{$company_web = 0}}">{{$company_web = 0}}</a>
                                        </div> 
                                    </div>
                                    @endif
                                    @foreach ($reserve_links = [] as $link)
                                            <div class="justify-content-center align-items-center cursor-pointer row m-0">
                                                <div class="col-md-12 mt-3 reserv-text pl-3 text-center">
                                                    <img class="mr-3" src="{{$link['thumb']}}" />
                                                    <a href="{{$link['link']}}">{{$link['name']}}</a>
                                                </div>
                                            </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-0 m-0 main-col pb-2 mt-2">
                            <div class="info-title mt-2">Social Media Feed</div> 
                            <div class="col-md-12 col-sm-12 info-social mb-0 p-0 pt-3">
                                <div class="w-100 mt-2 facebook text-center mt-4"><i class="fa fa-facebook"></i></div>
                                <div class="w-100 mt-2 twitter text-center"><i class="fa fa-twitter"></i></div>
                                <div class="w-100 mt-2 youtube text-center"><i class="fa fa-youtube"></i></div>                                
                            </div> 
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </taste-page>
@endsection
