@extends('layouts.main-page')

@section('content')
    <taste-restaurant-page inline-template
                           :companies="{{$companies}}"
                           :place_id="'{{$place['id']}}'">
        <main>
            <slider :data="[{img: '{{ $place['thumb'] }}', text: '{{$place['name']}}', class: 'explore-slider'},
                            ]">
            </slider>

            <section class="explore-cards custom-section">
                <div class="row explore-header mb-3" >
                    <h2 class="display-inline col-md-8">{{$place['name']}}</h2>
                    @if ($location_filter)
                        <div  class="filter-bar col-md-4">
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
                    @endif
                </div>
                <div class="section-content" v-if="list_companies.length">
                    <div class="row p-0">
                        <div class="default-card col-md-4 mb-4" v-for="company in list_companies">
                            <div class="default-wrapper">
                                <a :href="company.link" >
                                    <img :src="company.thumb"/>
                                    <div class="content">
                                        <h2 class="mb-3">@{{ company.name }}</h2>
                                    </div>
                                </a>
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
