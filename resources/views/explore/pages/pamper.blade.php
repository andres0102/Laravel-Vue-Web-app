@extends('layouts.main-page')

@section('content')
    <main>
        <slider :data="[{img: '{{ asset('assets/img/sliders/client-banner.jpeg') }}', text: 'PAMPER', class: 'explore-slider'},
                        {img: '{{ asset('assets/img/sliders/client-banner.jpeg') }}', text: 'PAMPER', class: 'explore-slider'},
                        {img: '{{ asset('assets/img/sliders/client-banner.jpeg') }}', text: 'PAMPER', class: 'explore-slider'}]">
        </slider>

        <section class="explore-cards">
            <div class="row explore-header mb-3">
                <h2 class="display-inline col-md-8">PAMPER</h2>
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
                @foreach($pampers as $pamper)
                    <div class="default-card col-md-4 mb-4">
                        <div class="default-wrapper">
                            <a href="{{ route('explore.pamper.detail', $pamper->id) }}">
                                <img src='{{ asset("assets/img/pamper/$pamper->thumbnail_image") }}' />
                                <div class="content">
                                    <h2 class="mb-1">{{ $pamper->title }}</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- EVENTS -->
            <div class="text-center">
                <h4>Events</h4>
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
@endsection