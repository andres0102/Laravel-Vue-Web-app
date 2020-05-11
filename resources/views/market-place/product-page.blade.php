@extends('layouts.main-page')

@section('content')
    <market-place-products-page inline-template :products="{{$products}}"
    :company_id="{{$company->id}}">
        <main>

            <slider :data="[{img: '{{ $company->transformThumb() }}', text: '{{strtoupper($company->company_name)}}', class: 'explore-slider'}]">
            </slider>
            <section class="product-cards mb-2">
                @if (!empty($categories))
                <div class="product-header" v-if="listProducts.length">
                    <h2>Sort By: </h2>
                    <span>
                        <select  @change="filter()" v-model="category">
                            <option value="false" selected>All</option>
                            @foreach ($categories as $category)
                            <option  :value="{{$category->category_id}}">{{$category->name}}</option>
                                @endforeach
                        </select>
                    </span>
                </div>
                @endif
                <div class="row" v-if="listProducts.length">
                        <div class="product-card col-md-4 mb-4" v-for="product in listProducts">
                            <div class="product-wrapper">
                                <a :href="product.url">
                                    <div class="image-header">
                                        <img :src="product.thumb" />
                                    </div>
                                    <div class="product-content">
                                        <h2 class="title">@{{product.name}}</h2>
                                        <h3 class="description">@{{product.simple_desc}}</h3>
                                        <div class="star-ratings-css">
                                            <div class="star-ratings-css-top" :style="{'width': product.rating * 10 +'%'}">
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                            </div>
                                            <div class="star-ratings-css-bottom">
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-footer">
                                        <span class="price">$ @{{product.price}}</span>
                                        <a class="read-more-link" :href="product.url">Read More</a>
                                    </div>
                                </a>
                            </div>
                        </div>
                </div>
                <div class="row text-empty" v-else>
                    <p>
                    No products
                    </p>
                </div>
                <div class="load-more col-md-12 text-center" v-if="showMore">
                    <a href="" @click.prevent="loadMore()">LOAD MORE</a>
                </div>
            </section>
        </main>
    </market-place-products-page>
@endsection
