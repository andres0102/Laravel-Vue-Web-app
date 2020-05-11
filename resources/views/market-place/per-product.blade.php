@extends('layouts.main-page')

@section('content')
    <market-place-page inline-template  stableprice="{{$product_info['price']}}" product="{{$product_info['id']}}"
    user_name="{{$user_name}}" rating_exists="{{$rating_exists}}">
        <main>

            <slider :data="[{img: '{{$company->transformThumb()}}', text: '{{strtoupper($company->company_name)}}', class: 'explore-slider'}]">
            </slider>

            <section class="product-details">
                <div class="header row">
                    <div class="left-text col-md-4">
                    </div>
                    <div class="image col-md-3">
                        <img src="{{$product_info['thumb']}}" />
                    </div>
                    <div class="price-content col-md-5">
                        <h2 class="title">{{$product_info['name']}}</h2>
                        <div class="rating w-100">
                            <div class="star-ratings-css">
                                <div class="star-ratings-css-top" style="width: {{$rating['rating']*10}}%">
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
                            <span class="number">{{$rating['rating']}} ({{$rating['count']}})</span>

                        </div>
                        <p class="description mt-3">
                            Lorem ipsum dolor morikue   protein from the Peruvian
                            rainforest. For optimum benefits, use with <b>shampure™
                            conditioner.</b>
                        </p>
                        @if (!empty($product_info['options']))
                        <div class="selects">
                            @foreach ($product_info['options'] as $options_group)
                            <div class="w-100">
                                <p>{{$options_group['name']}}</p>
                                <span>
                                    <select @change="changePrice($event)" name="{{$options_group['name']}}">
                                        <option disabled="" selected>Select Option</option>
                                        @foreach ($options_group['options'] as $one_option)
                                        <option data-price='{{$one_option['price']}}' value="{{$options_group['name']}}:{{$one_option['name']}}:{{$one_option['price']}}">{{$one_option['name']}}</option>
                                        @endforeach
                                    </select>
                                </span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        <div class="price-details w-100">
                            @if ($product_info['points'])
                            <span>Earn {{$product_info['points']}} Pure Privilege Points</span>
                            @endif
                            <span class="price" data-price="{{$product_info['price']}}">@{{model.price}}</span>
                        </div>

                        <div v-if="$auth.isAuthenticated()" class="buttons-section w-100 mt-4">
                            <a @click="addToBag()">ADD TO BAG</a>
                            <i @click="addToWishlist()" :class="{'fa fa-heart ml-4' : true, 'wishlist-added': wishlist}" aria-hidden="true"></i>
                            <i class="fa fa-share-square-o ml-3" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="description">
                    <div class="row">
                        <div class="col-3 tabs">
                            <div class="nav flex-column " id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-description-tab" data-toggle="pill" href="#v-pills-description" role="tab" aria-controls="v-pills-description" aria-selected="true">Description</a>
                                <a class="nav-link" id="v-pills-reviews-tab" data-toggle="pill" href="#v-pills-reviews" role="tab" aria-controls="v-pills-reviews" aria-selected="false" v-if="$auth.isAuthenticated()">Write review</a>
                                @if (count($galleryItems))
                                <a @click="runSlick()" class="nav-link" id="v-pills-video-tab" data-toggle="pill" href="#v-pills-video" role="tab" aria-controls="v-pills-video" aria-selected="false">Gallery</a>
                                    @endif
                            </div>
                        </div>
                        <div class="col-9 content">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-description" role="tabpanel" aria-labelledby="v-pills-description-tab">
                                    <h2>Product Description</h2>
                                    <p>
                                        {{$product_info['description']}}
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="v-pills-reviews" role="tabpanel" aria-labelledby="v-pills-reviews-tab" v-if="$auth.isAuthenticated()">
                                    <h2>Write review</h2>
                                    <div class="review-stars form-group" v-if="showRating">
                                        <fieldset class="rating">
                                            <input type="radio" id="star5"  name="rating" v-model="question.rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                            <input type="radio" id="star4half"  name="rating" v-model="question.rating" value="4.5" /><label class="half" for="star4half" ></label>
                                            <input type="radio" id="star4"  name="rating" v-model="question.rating" value="4" /><label class = "full" for="star4" ></label>
                                            <input type="radio" id="star3half" name="rating" name="question.rating" value="3.5" /><label class="half" for="star3half" ></label>
                                            <input type="radio" id="star3" name="rating" v-model="question.rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                            <input type="radio" id="star2half"  name="rating" v-model="question.rating" value="2.5" /><label class="half" for="star2half" ></label>
                                            <input type="radio" id="star2"  name="rating" v-model="question.rating" value="2" /><label class = "full" for="star2"></label>
                                            <input type="radio" id="star1half"  name="rating" v-model="question.rating" value="1.5" /><label class="half" for="star1half"></label>
                                            <input type="radio" id="star1"  name="rating" v-model="question.rating" value="1" /><label class = "full" for="star1"></label>
                                            <input type="radio" id="starhalf"  name="rating" v-model="question.rating" value="0.5" /><label class="half" for="starhalf" ></label>
                                        </fieldset>

                                    </div>
                                    <br>
                                        <div class="form-group">
                                            <label for="client-name">Your name</label>
                                            <input class="form-control" type="text" v-model="question.name" disabled/>
                                        </div>
                                        <div class="form-group">
                                            <label for="client-name">Your email</label>
                                            <input class="form-control" type="text" v-model="question.email"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="client-name">Your text</label>
                                            <textarea class="form-control" type="text" v-model="question.text" ></textarea>
                                        </div>
                                        <button @click="sendQuestion()" class="btn btn-lg button-for-site">Send question</button>
                                    <div class="col-sm-12" v-if="showError">
                                        <ul>
                                        <li class="text-danger" v-for="error in errors">
                                        @{{error[0]}}
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                                @if (count($galleryItems))
                                <div class="tab-pane fade" id="v-pills-video" role="tabpanel" aria-labelledby="v-pills-video-tab">
                                    <h2>Product Gallery</h2>
                                    <div class="product-sliders">
                                        <slick  style="margin:0 auto" >

                                            @foreach ($galleryItems as $galleryItem)
                                                {!!  $galleryItem->makeHtmlData() !!}
                                            @endforeach
                                        </slick>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @if(!empty($featured))
            <section class="product-cards mb-2">
                <div class="product-header text-center w-100 barlow-light mb-3">
                    <h2 class="font-size-30">Featured Products</h2>
                </div>
                <div class="row">
                    @foreach ($featured as $product)
                        <div class="product-card col-md-4 mb-4">
                            <div class="product-wrapper">
                                <a href="{{$product['url']}}">
                                    <div class="image-header">
                                        <img src="{{$product['thumb']}}" />
                                    </div>
                                    <div class="product-content">
                                        <h2 class="title">{{$product['name']}}</h2>
                                        <h3 class="description">{{$product['category']}}</h3>
                                        <div class="star-ratings-css">
                                            <div class="star-ratings-css-top" style="width: {{$product['rating'] * 10}}%">
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
                                        <span class="price">${{$product['price']}}</span>
                                        <a class="read-more-link" href="{{$product['url']}}">Read More</a>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
                @endif
        </main>
    </market-place-page>

@endsection

