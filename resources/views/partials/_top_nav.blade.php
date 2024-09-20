<nav class="navbar navbar-light">
    <div class="navbar-left">
        <div class="logo-area">
            <a class="navbar-brand" href="{{ route('dashboard', app()->getLocale()) }}">
                <img class="dark" src="{{ asset('assets/img/Today_Talks_Logo2.png') }}" alt="svg">
                <img class="light" src="{{ asset('assets/img/Today_Talks_Logo2.png') }}" alt="img">
            </a>
            <a href="#" class="sidebar-toggle">
                <img class="svg" src="{{ asset('assets/img/svg/align-center-alt.svg') }}" alt="img"></a>
        </div>

        <div class="top-menu">
            <div class="hexadash-top-menu position-relative">
                <ul>
                    <li>
                        <a href="{{ route('dashboard', app()->getLocale()) }}"
                            class="{{ Request::is(app()->getLocale() . '/pages/dashboard') ? 'active' : '' }}">
                            <span class="nav-icon uil uil-circle"></span>
                            <span class="menu-text">{{ trans('menu.blank-menu-title') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="navbar-right">
        <ul class="navbar-right__menu">
            <!-- <li class="nav-flag-select">
                <div class="dropdown-custom">
                    @switch(app()->getLocale())
                        @case('en')
                            <a href="javascript:;" class="nav-item-toggle"><img src="{{ asset('assets/img/eng.png') }}" alt="" class="rounded-circle"></a>
                            @break
                        @case('ar')
                            <a href="javascript:;" class="nav-item-toggle"><img src="{{ asset('assets/img/iraq.png') }}" alt="" class="rounded-circle"></a>
                            @break
                        @case('gr')
                            <a href="javascript:;" class="nav-item-toggle"><img src="{{ asset('assets/img/ger.png') }}" alt="" class="rounded-circle"></a>
                            @break
                        @default
                            <a href="javascript:;" class="nav-item-toggle"><img src="{{ asset('assets/img/eng.png') }}" alt="" class="rounded-circle"></a>
                            @break
                    @endswitch
                    @if(isset($find_customer))
                        @foreach ($find_customer as $customer)
                            <div class="dropdown-wrapper dropdown-wrapper--small">
                                <a href="{{ route(Route::currentRouteName(),['en',$customer->id]) }}"><img src="{{ asset('assets/img/eng.png') }}" alt=""> English</a>
                                <a href="{{ route(Route::currentRouteName(),['ar',$customer->id]) }}"><img src="{{ asset('assets/img/iraq.png') }}" alt=""> Arabic</a>
                                <a href="{{ route(Route::currentRouteName(),['gr',$customer->id]) }}"><img src="{{ asset('assets/img/ger.png') }}" alt=""> German</a>
                            </div>
                        @endforeach
                    @else
                        @php
                            $routeParams = Route::current()->parameters();
                        @endphp
                        <div class="dropdown-wrapper dropdown-wrapper--small">
                            <a href="{{ route(Route::currentRouteName(),$routeParams) }}"><img src="{{ asset('assets/img/eng.png') }}" alt=""> English</a>
                            <a href="{{ route(Route::currentRouteName(),$routeParams) }}"><img src="{{ asset('assets/img/iraq.png') }}" alt=""> Arabic</a>
                            <a href="{{ route(Route::currentRouteName(),$routeParams) }}"><img src="{{ asset('assets/img/ger.png') }}" alt=""> German</a>
                        </div>
                    @endif
                </div>
            </li> -->
            <li class="nav-author">
                <div class="dropdown-custom">
                    <a href="javascript:;" class="nav-item-toggle"><img src="{{ asset('assets/img/author-nav.jpg') }}"
                            alt="" class="rounded-circle">
                        @if(Auth::check())
                            <span class="nav-item__title">{{ Auth::user()->name }}<i
                                    class="las la-angle-down nav-item__arrow"></i></span>
                        @endif
                    </a>
                    <div class="dropdown-wrapper">
                        <div class="nav-author__info">
                            <div class="author-img">
                                <img src="{{ asset('assets/img/author-nav.jpg') }}" alt="" class="rounded-circle">
                            </div>
                            <div>
                                @if(Auth::check())
                                    <h6 class="text-capitalize">{{ Auth::user()->name }}</h6>
                                @endif
                            </div>
                        </div>
                        <div class="nav-author__options">
                            <ul>
                                <!-- <li>
                                    <a href="">
                                        <img src="{{ asset('assets/img/svg/user.svg') }}" alt="user" class="svg"> Profile</a>
                                </li> 
                                <li>
                                    <a href="{{ route('baseSetting.all', app()->getLocale()) }}">
                                        <img src="{{ asset('assets/img/svg/settings.svg') }}" alt="settings" class="svg"> Settings</a>
                                </li>-->
                            </ul>
                            <a href="" class="nav-author__signout"
                                onclick="event.preventDefault();document.getElementById('logout').submit();">
                                <img src="{{ asset('assets/img/svg/log-out.svg') }}" alt="log-out" class="svg">
                                Sign Out</a>
                            <form style="display:none;" id="logout" action="{{ route('logout') }}" method="POST">
                                @csrf
                                @method('post')
                            </form>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <div class="navbar-right__mobileAction d-md-none">
            <a href="#" class="btn-search">
                <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg feather-search">
                <img src="{{ asset('assets/img/svg/x.svg') }}" alt="x" class="svg feather-x">
            </a>
            <a href="#" class="btn-author-action">
                <img src="{{ asset('assets/img/svg/more-vertical.svg') }}" alt="more-vertical" class="svg"></a>
        </div>
    </div>
</nav>