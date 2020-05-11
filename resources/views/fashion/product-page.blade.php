@extends('layouts.main-page')

@section('content')
    <fashion-products-page inline-template :products="{{$products}}"
    :category_id="'{{$category?$category->id:''}}'"
    :type="'{{$type}}'">
        <main>
            @if ($category && $category->category_thumb)
            <slider :data="[{img: '{{ $category->transformThumb() }}', text: '{{strtoupper($category->name)}}', class: 'explore-slider'}]">
            </slider>
            @endif
            <section class="product-cards mb-2">
                    <div class="product-header" v-if="listProducts.length">
                        <h2>Sort By: </h2>
                        <span>
                        <select  @change="sortProducts()" v-model="sortValue">
                            <option value="0" disabled selected>Select</option>
                            <option value="rating" >Top rated</option>
                            <option value="price" >Price</option>
                            <option value="name" >Name</option>
                        </select>
                    </span>
                    </div>
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
    </fashion-products-page>
@endsection
