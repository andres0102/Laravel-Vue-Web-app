<navbar inline-template>
    <div class="custom-navbar">
        <template v-if="showVipBar">
            <div class="navbar-vip-box text-center" role="alert">
                <a class="text-dark" href="{{ route('advertise-b-user-page') }}">Become a VIP</a>
                <button type="button" class="close pr-2" data-dismiss="alert" aria-label="Close" @click="hideVipBar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </template>
        <div class="navbar-wrapper p-1">
            <a class="logo" href="{{ route('main-page') }}">
                <img alt="logo" src="{{ asset('assets/img/logo.png') }}">
            </a>
            <div class="navbar-content">
                <ul class="navigation">
                    <li><a href="{{ route('main-page') }}">HOME</a></li>
                    <li><a href="{{ route('explore-page') }}">EXPLORE</a></li>
                    <li><a href="{{ route('fashion-page') }}">FASHION</a></li>
                    <li><a href="{{ route('taste-page') }}">TASTE</a></li>
                    <li><a href="{{ route('market-place-page') }}">LOCAL MARKETPLACE</a></li>
                    <li><a href="{{ route('music-page') }}">MUSIC</a></li>
                    <li><a href="{{ route('stay-page') }}">STAY</a></li>
                    <li><a href="{{ route('events-page') }}">EVENTS</a></li>
                    <li><a href="{{ route('advertise-page') }}">ADVERTISE WITH US!</a></li>
                </ul>
                @include('layouts.partials.auth-menu')
                <span class="menu" @click="toogleMenu">
                    <template v-if="isToogleNavbar">
                        <i class="fa fa-close" aria-hidden="true"></i>
                        Close
                    </template>
                    <template v-else>
                        <i class="fa fa-bars" aria-hidden="true"></i>
                        Menu
                    </template>
                </span>
            </div>
        </div>
    </div>
</navbar>
