@extends('layouts.main-page')

@section('content')
    <explore-page inline-template>
        <main class="explore-page">
            <slider :data="[{img: '{{ asset('assets/img/sliders/adventure-profile.png') }}', text: 'EXPLORE', class: 'explore-slider'}]">
            </slider>

            <section class="explore-cards">
                <h2 class="explore-title text-center mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sapien enim, fringilla et consequat at, interdum eu augue. Pellentesque ligula urna, ultricies in bibendum eget, pharetra at nibh. </h2>
                @if ($types)

                <div class="row">
                    @foreach($types as $type)
                    <div class="explore-card mb-4 col-md-4">
                        <div class="explore-wrapper">
                            <div class="image-header">
                                <img src="{{$type->transformThumb()}}"/>
                            </div>
                            <div class="content">
                                <h2>{{$type->explore_type_name}}</h2>
                                <p class="text">
                                    {{$type->explore_type_shor_desc}}
                                </p>
                                <a class="read-more-btn mt-2 float-none" href="{{ route('explore-subpage', ['type_url' => $type->explore_type_seourl]) }}">READ MORE</a>
                            </div>
                        </div>
                    </div>
                        @endforeach

                </div>

                @endif
            </section>

            <events-widget></events-widget>
        </main>
    </explore-page>
@endsection
