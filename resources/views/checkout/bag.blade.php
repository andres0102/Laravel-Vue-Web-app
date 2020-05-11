@extends('layouts.main-page')

@section('content')
    <bag-page inline-template  total="{{$total}}">
        <main>
            <div class="loading-wait" v-if="showLoading"><img src="{{ asset('assets/img/loading.svg')}}"></div>
            @if (!empty($products))
                <div class="header-text col-sm-12">
                    <h2>Your Bag</h2>
                </div>
                <div class="bag-block">
                    <div class="col-sm-12 bag-items">
                        <div class="container">
                            <table id="cart" class="table table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th style="width:10%">Number</th>
                                    <th style="width:20%">Image</th>
                                    <th style="width:8%">Product name</th>
                                    <th style="width:30%">Options</th>
                                    <th style="width:15%" class="text-center">Quantity</th>
                                    <th style="width:10%">Price</th>
                                    <th style="width:10%">Total</th>
                                    <th style="width:25%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($products as $product)
                                    <tr id="product{{$product['id']}}">
                                        <td data-th="Number">
                                            {{$i}}
                                        </td>
                                        <td data-th="Image">
                                            <img src="{{$product['thumb']}}"/>
                                        </td>
                                        <td data-th="Product name">
                                            {{$product['name']}}
                                        </td>
                                        <td data-th="Options">
                                            {!! nl2br(e($product['options'])) !!}
                                        </td>
                                        <td data-th="Quantity">
                                            <input id="quantity{{$product['id']}}"  name="quantity"   value="{{$product['quantity']}}" type="number" class="form-control text-center"/>
                                        </td>
                                        <td data-th="Price" id="price{{$product['id']}}">${{$product['price']}}</td>
                                        <td data-th="Total" id="total{{$product['id']}}" class="text-center">
                                            ${{$product['total']}}
                                        </td>
                                        <td class="actions" data-th="">
                                            <button @click="calcPrice({{$product['id']}})" class="btn btn-info btn-sm"><i class="fa fa-refresh"></i></button>
                                            <button @click="calcPrice({{$product['id']}},0)" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                        </td>
                                    </tr>
                                @php
                                    $i++;
                                @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="total-block col-sm-12">
                    <h3>Bag subtotal </h3>
                        <p class="text-danger font-48px">@{{totalPrice}}</p>
                    </div>
                    <div class="address-info info-blocks">
                        <h3 class="col-sm-12">Address</h3>
                        <div class="address-form col-sm-12">
                            <div class="form-group">
                                <label for="address-company">Company name</label>
                                <input class="form-control"  id="address-company" v-model="payment.company" name="company" >
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input class="form-control"  id="address" v-model="payment.address" name="address">
                            </div>
                            <div class="form-group">
                                <label for="address-city">Address city</label>
                                <input class="form-control"  id="address-city" v-model="payment.city" name="city">
                            </div>
                            <div class="form-group">
                                <label for="address-state">State</label>
                                <input class="form-control"  id="address-state" v-model="payment.state" name="state" >
                            </div>
                            <div class="form-group">
                                <label for="address-zip">Zip code</label>
                                <input class="form-control"  id="address-zip" v-model="payment.zip" name="zip" >
                            </div>
                            <div class="form-group">
                                <label for="address-country">Country</label>
                                <input class="form-control"  id="address-country" v-model="payment.country" name="country" >
                            </div>
                        </div>
                    </div>
                    <div class="card-info info-blocks">
                        <h3 class="col-sm-12">Payment</h3>
                        <div class="card-form col-sm-12">
                            <div class="form-group">
                                <label for="card-number">Card Number</label>
                                <input class="form-control"  id="card-number" v-model="payment.cardNumber" name="cardNumber" >
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label for="card-month">Month</label>
                                    <select class="form-control"  id="card-month" v-model="payment.cardExMonth" name="cardNumber" >
                                        @for ($i = 1; $i<=12; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="card-year">Year</label>
                                    <select class="form-control"  id="card-year" v-model="payment.cardExYear" name="cardNumber" >
                                    @for ($i = date('Y'); $i<3000; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="card-code">Security Code (CVV)</label>
                                    <input class="form-control"  id="card-code" v-model="payment.cardCode" name="cardNumber" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="card-number">Cardholder name</label>
                                <input class="form-control"  id="card-number" v-model="payment.cardHolderName" name="cardNumber">
                            </div>
                            <div class="alert alert-danger" role="alert" v-if="showError">@{{error_text}}</div>
                            <button type="button" class="btn btn-warning" @click="sendPayment()">Submit</button>
                        </div>

                    </div>
                </div>
                @else
                <div class="no-items-in-bag">
                    <h2>There are no products in bag</h2>
                    <p> <a href="{{route('main-page')}}">Go to main page</a></p>
                </div>
            @endif

        </main>
    </bag-page>
@endsection
