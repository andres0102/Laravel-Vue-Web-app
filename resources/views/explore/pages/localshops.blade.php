@extends('layouts.main-page')

@section('content')
    <main>
        <slider :data="[{img: '{{ asset('assets/img/sliders/client-banner.jpeg') }}', text: 'LOCAL SHOPS AND SHOPPING', class: 'explore-slider'},
                        {img: '{{ asset('assets/img/sliders/client-banner.jpeg') }}', text: 'LOCAL SHOPS AND SHOPPING', class: 'explore-slider'},
                        {img: '{{ asset('assets/img/sliders/client-banner.jpeg') }}', text: 'LOCAL SHOPS AND SHOPPING', class: 'explore-slider'}]">
        </slider>

        <section class="explore-cards">
            <div class="row explore-header mb-3">
                <h2 class="display-inline col-md-8">LOCAL SHOPS AND SHOPPING</h2>
                <div class="filter-bar col-md-4">
                    <span>
                        <select>
                            <option value="Select">Location Filter</option>
                            <option value="bar1">Bar 1</option>
                            <option value="bar2">Bar 2</option>
                        </select>
                    </span>
                    <a class="filter-btn ml-3" href="#">Find Filter</a>
                </div>
            </div>
            <div class="row">
                @foreach($localshops as $localshop)
                    <div class="default-card col-md-4 mb-4">
                        <div class="default-wrapper">
                            <a href="{{ route('explore.localshop.detail', $localshop->id) }}">
                                <img src='{{ asset("assets/img/localshop/$localshop->thumbnail_image") }}' />
                                <div class="content">
                                    <h2 class="mb-1">{{ $localshop->title }}</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <!-- EVENTS -->
        <events-widget></events-widget>
    </main>
@endsection