@extends('layouts.main-page')

@section('content')
    <taste-restaurant-page inline-template
    :companies="{{$companies = 1}}"
    :place_id="'{{$place['id'] = 1}}'">
        <main>
            <slider :data="[{img: '{{ asset('assets/img/sliders/taste.png') }}', text: 'Restaurants', class: 'explore-slider'},
                            {img: '{{ asset('assets/img/sliders/taste.png') }}', text: 'Restaurants', class: 'explore-slider'},
                            {img: '{{ asset('assets/img/sliders/taste.png') }}', text: 'Restaurants', class: 'explore-slider'}]">
            </slider>

            <section class="explore-cards custom-section">
                <div class="row explore-header mb-3 m-0 mr-2 chef-flex " >
                    <div class="col-md-4 pl-4">
                        <input class="chefs-search" type="text" v-model="search_value" placeholder="Search"/>
                        <i class="fa fa-search chefs-search-icon pt-1"  @click="searchItems()"></i>
                    </div>
                   
                    <div class="filter-bar col-md-8 text-right m-0 mt-2">
                        <span>
                            <select v-model="location" >
                                <option value="false"  disabled >Location Filter</option>
                                <option value="0">All locations</option>
                                @foreach( $location_filter as $location_value)
                                    <option value="{{$location_value->company_location}}"  >{{$location_value->company_location}}</option>
                                @endforeach

                            </select>
                        </span>
                        <a class="filter-btn ml-3" @click="filterItems()">Find Filter</a>
                    </div>
                   
                </div>
                <div class="section-content" v-if="list_companies.length">
                    <div class="row p-0">
                        <div class="taste-card text-center col-md-4 mt-3 p-0 m-0" v-for="company in list_companies">
                            <div class="taste-wrapper">
                                <div class="image-header">
                                    <a :href="company.link">
                                        <img :src="company.thumb" />
                                    </a>
                                </div>
                                <div class="content">
                                    <h2 class="chefs-h2">@{{ company.name }}</h2>
                                    <span class="chefs-span">@{{ company.desc }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-content" v-else>
                    <div class="text-empty"><p>No companies</p></div>
                </div>
            </section>
        </main>
    </taste-restaurant-page>
@endsection
