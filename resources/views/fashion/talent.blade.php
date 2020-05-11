@extends('layouts.main-page')

@section('content')
    <fashion-one-talent-page inline-template>
        <main>
            <slider :data="[{img: '{{ $talent->transformThumb()}}', text: '{{$talent->talent_name}}', class: 'explore-slider'}]">
            </slider>

            <section class="profile-page music-show-page">
                {{--<h2 class="title text-center">--}}
                    {{--<a class="black-btn mr-3" href="#">Book Me For Your Event</a>--}}
                    {{--<a class="black-btn" href="{{ route('music-product-page') }}">Full Music Collection</a>--}}
                {{--</h2>--}}
                <h2 class="title">{{$talent->talent_name}}</h2>

                <div class="row">
                    <div class="description col-md-8 col-sm-12 mb-4">
                        <div class="main-text">
                            <h2>Bio</h2>
                            <p>
                                {{$talent->talent_desc}}
                            </p>
                        </div>
                        <h2 class="medium-title mt-4 mb-4">PAST EVENTS</h2>
                        <div class="row p-0 m-0">
                            @for($i = 1; $i < 4; $i++)
                                <div class="col-md-4 past-event-card mb-4 p-0 pr-2">
                                    <div class="past-event-wrapper">
                                        <img src="{{ asset('assets/img/music/' . $i . '.png') }}" />
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <h2 class="medium-title mt-4 mb-4">UPCOMING EVENTS FOR {{$talent->talent_name}} </h2>
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
                    @if($talent->fb_link || $talent->twt_link || $talent->ytb_link)
                    <div class="right-side col-md-4 col-sm-12 p-0 m-0 pt-2 pl-4" >
                        <div class="col-md-12 p-0 m-0 main-col pb-2 mt-5">
                            <div class="info-title mt-2">Social Media</div>
                            <div class="col-md-12 col-sm-12 info-social mb-0 p-0">
                                @if($talent->fb_link)
                                    <div class="w-100 mt-2 facebook text-center "><a href="{{$talent->fb_link}}"><i class="fa fa-facebook"></i></a></div>
                                @endif
                                @if($talent->twt_link)
                                        <div class="w-100 mt-2 twitter text-center"><a href="{{$talent->twt_link}}"><i class="fa fa-twitter"></i></a></div>
                                @endif
                                @if($talent->ytb_link)
                                        <div class="w-100 mt-2 youtube text-center"><a href="{{$talent->ytb_link}}"><i class="fa fa-youtube"></i></a></div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </section>
        </main>
    </fashion-one-talent-page>
@endsection
