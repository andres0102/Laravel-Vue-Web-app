@extends('layouts.main-page')

@section('content')
    <explore-designer-page inline-template
                           :companies="{{$companies}}">
        <main>
            <slider :data="[{img: '{{ asset('assets/img/sliders/banner7.jpeg') }}', text: 'Local Designers/Fashion Houses', class: 'explore-slider'},
                            {img: '{{ asset('assets/img/sliders/banner7.jpeg') }}', text: 'Local Designers/Fashion Houses', class: 'explore-slider'},
                            {img: '{{ asset('assets/img/sliders/banner7.jpeg') }}', text: 'Local Designers/Fashion Houses', class: 'explore-slider'}]">
            </slider>

            <section class="explore-cards">
                <div class="row explore-header mb-3">
                    <h2 class="display-inline col-md-8">Local Designers/Fashion Houses</h2>
                    {{--<div class="filter-bar col-md-4">--}}
                        {{--<span>--}}
                            {{--<select>--}}
                                {{--<option value="Select">Location Filter</option>--}}
                                {{--<option value="bar1">Bar 1</option>--}}
                                {{--<option value="bar2">Bar 2</option>--}}
                            {{--</select>--}}
                        {{--</span>--}}
                        {{--<a class="filter-btn ml-3" href="#">Find Filter</a>--}}
                    {{--</div>--}}
                </div>
                <div class="row" v-if="listCompanies.length">
                        <div class="default-card col-md-4 mb-4" v-for="company in listCompanies">
                            <div class="default-wrapper">
                                <a  :href="company.url" >
                                    <img :src='company.thumb' />
                                    <div class="content">
                                        <h2 class="mb-3">Client @{{company.name }}</h2>
                                    </div>
                                </a>
                            </div>
                        </div>
                </div>
                <div class="row" v-else>
                    No companies
                </div>
            </section>

            <!-- EVENTS -->
            <events-widget></events-widget>
        </main>
    </explore-designer-page>
@endsection
