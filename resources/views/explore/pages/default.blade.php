@extends('layouts.main-page')

@section('content')
    <explore-page-list inline-template
                       :list="{{$items}}"
    :categoryurl="'{{$category_url}}'"
    :typeurl="'{{$type_url}}'"
    :type_id="'{{$type->id}}'"><main>
            @if (!empty($gallery))
            <slider :data="[
            @foreach ($gallery as $gallery_item)
            {img: '{{$gallery_item}}', text: '{{$category}}', class: 'explore-slider'},
            @endforeach

            ]">
            </slider>
                @else
                <slider :data="[{img: '{{$type->transformThumb()}}', text: '{{$category}}', class: 'explore-slider'}]">
                </slider>
            @endif
            <section class="explore-cards">
                <div class="row explore-header mb-3">
                    @if ($type->id == 2)
                        <h2 class="display-inline col-md-8">@{{filter_name}}</h2>
                    @else
                    <h2 class="display-inline col-md-8">{{$category }}</h2>
                    @endif


                    @if(!empty($filter))
                    <div class="filter-bar col-md-4">
                        @foreach ($filter as $groupName => $filterGroup)
                        <p class="filter-name">{{$groupName}}</p>
                        <span>

                            <select v-model="selectVal" >
                                <option value="0" selected>All</option>
                                    @foreach($filterGroup as $filterKey => $filterValue)
                                <option :value="{{$filterKey}}">{{$filterValue}}</option>
                                    @endforeach
                            </select>
                        </span>
                        @endforeach
                        <a class="filter-btn ml-3" @click="filterItems(); return false;" >Find Filter</a>
                    </div>
                    @endif
                </div>
                <div class="row" v-if="items.length">
                    <div v-for="item in items" class="default-card col-md-4 mb-4">
                        <div class="default-wrapper">
                            <a :href="item.link">
                                <img :src='item.thumb' />
                                <div class="content">
                                    <h2 class="mb-3">@{{item.name}}</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row" v-else>
                    <div class="text-center">
                        <p>No items in category</p>
                    </div>
                </div>
            </section>

            <!-- EVENTS -->
            @if($category_url)
                <events-widget :layout-list="true"></events-widget>
                @else
            <events-widget></events-widget>
            @endif

        </main>
    </explore-page-list>
@endsection
