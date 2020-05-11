@extends('layouts.main-page')

@section('content')
    <fashion-page inline-template>
        <main>
            <slider :data="[{img: '{{ asset('assets/img/sliders/fashion.jpeg') }}', text: 'FASHION', class: 'explore-slider'},
                            {img: '{{ asset('assets/img/sliders/fashion.jpeg') }}', text: 'FASHION', class: 'explore-slider'},
                            {img: '{{ asset('assets/img/sliders/fashion.jpeg') }}', text: 'FASHION', class: 'explore-slider'}]">
            </slider>

            <section class="fashion-cards mb-2">
                <div class="fashion-header">
                    <h2>FASHION</h2>
                </div>
                <div class="row">
                    <div class="default-card col-md-4 mb-4">
                        <div class="default-wrapper">
                            <a href="{{ route('fashion-local-designer-page') }}">
                                <img src="{{asset('assets/img/fashion/fash1.png')}}" />
                                <div class="content">
                                    <h2 class="mb-3">Local Designers/Fashion Houses</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="default-card col-md-4 mb-4">
                        <div class="default-wrapper">
                            <a href="{{ route('fashion-spotlight-on-page') }}">
                                <img src="{{asset('assets/img/fashion/fash2.png')}}" />
                                <div class="content">
                                    <h2 class="mb-3">Spotlight On</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="default-card col-md-4 mb-4">
                        <div class="default-wrapper">
                            <a href="{{ route('fashion-display-sort-products-page',['sort'=>'exclusive']) }}">
                                <img src="{{asset('assets/img/fashion/fash3.png')}}" />
                                <div class="content">
                                    <h2 class="mb-3">Exclusively The Loops</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="default-card col-md-4 mb-4">
                        <div class="default-wrapper">
                            <a href="{{ route('fashion-display-sort-products-page',['sort'=>'new-arrivals']) }}">
                                <img src="{{asset('assets/img/fashion/fash4.png')}}" />
                                <div class="content">
                                    <h2 class="mb-3">New Arrivals</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="default-card col-md-4 mb-4">
                        <div class="default-wrapper">
                            <a href="{{ route('fashion-display-sort-products-page',['sort'=>'must-have']) }}">
                                <img src="{{asset('assets/img/fashion/fash5.png')}}" />
                                <div class="content">
                                    <h2 class="mb-3">Must Haves</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="default-card col-md-4 mb-4">
                        <div class="default-wrapper">
                            <a href="{{ route('fashion-hautre-coutre-page') }}">
                                <img src="{{asset('assets/img/fashion/fash6.png')}}" />
                                <div class="content">
                                    <h2 class="mb-3">Haute Couture</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="fashion-tabs">
                @if (!empty($categories))
                <ul class="nav" id="pills-tab">
                    @foreach($categories as $category)
                        <li class="nav-item mr-2 mt-2">
                            <a class="nav-link active" id="pills-women-tab" href="{{$category['cat_link']}}" role="tab" aria-controls="pills-women" aria-selected="true">{{$category['can_name']}}</a>
                        </li>
                    @endforeach
                </ul>
                @endif
                @if (!empty($products))
                <h2 class="fashion-tab-title mt-5 mb-4">CUSTOMER FAVORITES</h2>
                <div class="tab-content mt-3" >
                    <div class="tab-pane fade show active" id="pills-women" role="tabpanel" aria-labelledby="pills-women-tab">
                        <div class="row cards-row m-0">
                            @foreach ($products as $product)
                                <div class="fashion-tab-card col-md-4 p-0">
                                    <div class="fashion-tab-wrapper">
                                        <a href="{{$product['url']}}">
                                            <div class="image-header">
                                                <img src="{{$product['thumb']}}"/>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                    @endif
            </section>

             <!-- EVENTS -->
             <events-widget></events-widget>
        </main>
    </fashion-page>
@endsection
