@extends('layouts.main-page')

@section('content')
    <explore-profile-page inline-template>
        <main class="adventure-profile-page">
            <slider :data="[{img: '{{ asset("assets/img/localshop/$localshop->thumbnail_image") }}', text: '{{$localshop->title}}', class: 'explore-slider'}]">
            </slider>

            <section class="profile-page">
                <div class="row">
                    <div class="description col-md-8 col-sm-12 mb-4">
                        <h2 class="title">{{$localshop->title}}</h2>
                        <div class="main-text">
                            <h2>Business Description</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam consequat, mi a blandit sollicitudin, eros neque sodales felis, nec consequat ex urna eu ipsum. Fusce vel neque id tortor tempor pharetra eu non urna. Sed sed metus euismod, varius sem ac, cursus quam. Nulla eu orci sit amet purus aliquam gravida at lacinia odio. Duis non erat sem. Sed dignissim scelerisque libero, in ornare ligula aliquam vel. Fusce rutrum justo ac egestas malesuada. Pellentesque mi odio, suscipit in orci in, tincidunt semper enim. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam consequat, mi a blandit sollicitudin, eros neque sodales felis, nec consequat ex urna eu ipsum. Fusce vel neque id tortor tempor pharetra eu non urna. Sed sed metus euismod, varius sem ac, cursus quam. Nulla eu orci sit amet purus aliquam gravida at lacinia odio. Duis non erat sem. Sed dignissim scelerisque libero, in ornare ligula aliquam vel. Fusce rutrum justo ac egestas malesuada. Pellentesque mi odio, suscipit in orci in, tincidunt semper enim. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
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
                                @if(1)
                                <div class="row pt-0 pb-0">
                                    <div class="col-md-1">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <div class="col-md-11">
                                        445 Mount Eden Road, Mount Eden Auckland
                                    </div>     
                                </div>
                                @endif
                                @if (1)
                                <div class="row pt-0 pb-0">
                                    <div class="col-md-1">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <div class="col-md-11">
                                       Monday - Friday 8AM - 9PM Saturday - Sunday 1PM - 10PM
                                    </div>     
                                </div>
                                @endif
                                @if (1)
                                <div class="row pt-0 pb-0">
                                    <div class="col-md-1">
                                        <i class="fa fa-phone"></i> 
                                    </div>
                                    <div class="col-md-11">
                                        23 4567 8901 / 123 4567 8901
                                    </div> 
                                </div>
                                @endif
                                @if (1)
                                <div class="row pt-0 pb-0">
                                    <div class="col-md-1">
                                        <i class="fa fa-dribbble"></i>
                                    </div>
                                    <div class="col-md-11">
                                        www.website.com
                                    </div> 
                                </div>
                                @endif
                            </div>
                            @if(1)
                            <div class="info-title mt-2">Social Media</div> 
                            <div class="col-md-12 col-sm-12 info-social mb-0 p-0">
                                @if (1)
                                    <a href="https://www.facebook.com/">
                                        <div class="w-100 mt-3 facebook text-center "><i class="fa fa-facebook"></i></div>
                                    </a>
                                @endif
                                @if(1)
                                        <a href="https://www.twitter.com/"><div class="w-100 mt-2 twitter text-center"><i class="fa fa-twitter"></i></div></a>
                                @endif
                                @if (1)
                                    <a href="https://www.youtube.com/">
                                        <div class="w-100 mt-2 mb-3 youtube text-center"><i class="fa fa-youtube"></i></div>
                                    </a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- EVENTS -->
                <div class="text-center">
                    <h4>UPCOMING EVENTS</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
                </div>
                <div class="events events_list my-2">
                    @for ($i = 0; $i < 2; $i++)
                        @component('components.event2')
                        @endcomponent
                    @endfor
                </div>
            </section>
        </main>
    </explore-profile-page>
@endsection
