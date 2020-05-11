@extends('layouts.main-page')

@section('content')
    <market-place-main-page inline-template
                            :companies="{{$companies}}"
    :companiestypes="{{$companiesType}}">
        <main>
            <slider :data="[{img: '{{ asset('assets/img/marketplace/marketplace.png') }}', text: 'LOCAL MARKETPLACE', class: 'explore-slider'},
                            {img: '{{ asset('assets/img/marketplace/marketplace.png') }}', text: 'LOCAL MARKETPLACE', class: 'explore-slider'},
                            {img: '{{ asset('assets/img/marketplace/marketplace.png') }}', text: 'LOCAL MARKETPLACE', class: 'explore-slider'}]">
            </slider>
            <section class="custom-section mb-0 pb-0">
                <div class="section-header">
                    <div class="mt-4 marketplace-nav">
                        <a class="active" href="">MAP</a>
                        <a :class="{'active-head-item':sort}" @click.prevent="setSort()">MERCHANTS A TO Z </a>
                        <template v-for="type in listCompanyTypes">
                            <a :class="{'active-head-item':filter == type.id}"  @click.prevent="setFilter(type.id)">@{{type.type_name}}</a>
                        </template>
                    </div>
                </div>
                <div class="section-content ">
                    <div class="row" v-if="listCompany.length">
                            <div v-for="company in listCompany" class="market-card text-left col-md-4 mt-3">
                                <div class="market-wrapper p-0">
                                    <div class="image-header">
                                        <a :href="company.url">
                                            <img :src="company.thumb" />
                                            <span class="text text-uppercase">@{{company.name}}</span>
                                        </a>
                                    </div>

                                    <div class="content pt-4 company-desc-link">
                                       <p> @{{company.desc}}</p>
                                        <a class="read-more-link" :href="company.url">READ MORE</a>
                                    </div>
                                </div>
                            </div>

                    </div>
                    <div class="row" v-else>
                        <div class="col-sm-12 text-empty">
                            There is no companies. Please, try again later!
                        </div>
                    </div>
                </div>
                <div class="load-more col-md-12 text-center mt-4" v-if="showButton">
                    <a href="" @click.prevent="loadMore($event)">LOAD MORE</a>
                </div>
            </section>
            <events-widget></events-widget>
        </main>
    </market-place-main-page>
@endsection
