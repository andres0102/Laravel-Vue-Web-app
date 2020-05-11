@extends('layouts.main-page')

@section('content')
    <fashion-products-page inline-template :products="{{$products = 0}}"
                           :category_id="'{{$category = false ? $category->id : ''}}'">
        <main>
            <slider :data="[{img: '{{ asset('assets/img/sliders/must-haves.png') }}', text: 'Must Haves', class: 'explore-slider'}]">
            </slider>
            <section class="must-haves-description">
                <h2 class="must-title">Get Ready for Fall (sample title)</h2>
                <p class="must-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas urna ex, iaculis non porttitor eget, pulvinar eu lorem. Nunc at consequat ante. Suspendisse nec ante blandit, condimentum sem ut, auctor mauris. Aliquam sit amet auctor odio.</p>
                <p class="must-text">Vestibulum elementum ullamcorper tortor, sed rhoncus felis. Phasellus tempor elit quis ex volutpat porttitor. Vivamus quis justo velit. Sed accumsan urna ac lectus posuere. Phasellus tempor elit quis ex volutpat porttitor. Vivamus quis justo velit. Sed accumsan urna ac lectus posuere laoreet. Aenean volutpat tellus vel sem facilisis vulputate. </p>                
            </section>
            <section class="product-cards mb-2">
                <div class="product-header must-haves-header w-100 mb-4">
                    <div>
                        <h2 class="haves-title">FEATURED PRODUCTS</h2>
                    </div>
                    <div>
                        <h2>Sort By: </h2>
                        <span>
                            <select>
                                <option value="Select">POPULARITY</option>
                                <option value="bar1">Bar 1</option>
                                <option value="bar2">Bar 2</option>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="row m-0" v-if="listProducts.length">
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
                    <a href="{{ route('fashion-product-page') }}">LOAD MORE</a>  
                </div>
            </section>
        </main>
    </fashion-products-page>
@endsection
