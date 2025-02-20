<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">

        @yield('meta_tags')

        {{-- favicon --}}
        <link rel="shortcut icon" href="/images/site/{{ isset(settings()->site_favicon) ? settings()->site_favicon : '' }}" type="image/x-icon">
        <link rel="icon" href="/images/site/{{ isset(settings()->site_favicon) ? settings()->site_favicon : '' }}" type="image/x-icon">

        <link rel="stylesheet" href="/front/plugins/bootstrap/bootstrap.min.css">

        <link rel="stylesheet" href="/front/css/animate.min.css">
        <link rel="stylesheet" href="/front/plugins/themify-icons/themify-icons.css">
        <link rel="stylesheet" href="/front/plugins/slick/slick.css">
        <link rel="stylesheet" href="/extra-assets/ijabo/css/ijabo.min.css">

        <link rel="stylesheet" href="/front/css/style.css">

        @stack('stylesheets')

    </head>

    <body>

        <!-- navigation -->
        <header class="sticky-top bg-white border-bottom border-default">
            <div class="container">

                {{-- nav bar --}}
                <nav class="navbar navbar-expand-lg navbar-white">

                    <a class="navbar-brand" href="/">
                        <img class="img-fluid" width="150px" src="/images/site/{{ isset(settings()->site_logo) ? settings()->site_logo : '' }}" alt="{{ isset(settings()->site_title) ? settings()->site_title : '' }}">
                    </a>

                    <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navigation">
                        <i class="ti-menu"></i>
                    </button>

                    <div class="collapse navbar-collapse text-center" id="navigation">

                        <ul class="navbar-nav ml-auto">

                            <li class="nav-item">
                                <a class="nav-link" href="/">Home</a>
                            </li>

                            @foreach (get_pages('header') as $page )
                                <li class="nav-item">
                                    {{-- <a class="nav-link" href="{{ route('show_page', $page->slug) }}">{{ $page->title }}</a> --}}
                                </li>
                            @endforeach

                            {!! navigations() !!}

                            {{-- contact route --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                            </li>

                        </ul>

                        <!-- search -->
                        <div class="search px-4">
                            <button id="searchOpen" class="search-btn"><i class="ti-search"></i></button>
                            <div class="search-wrapper">

                                <form action="{{ route('search_posts') }}" method="GET" class="h-100">
                                    @csrf
                                    <input class="search-box pl-4" id="search-query" name="q" type="search" placeholder="Type to discover articles, guide &amp; tutorials... " value="{{ request('q') ? request('q') : '' }}">
                                </form>

                                <button id="searchClose" class="search-close"><i class="ti-close text-dark"></i></button>
                            </div>
                        </div>

                    <!-- User Details + Dropdown -->
                    @auth

                        <div class="user-details">

                            <img src="{{ auth()->user()->picture }}" alt="User Avatar">

                            <div class="user-dropdown">

                                <a href="{{ route('admin.dashboard') }}">
                                    <i class="ti-dashboard"></i>Dashboard
                                </a>

                                <a href="{{ route('admin.profile') }}">
                                    <i class="ti-user"></i>Profile
                                </a>

                                @if ( auth()->user()->type == "superAdmin" )
                                    <a href="{{ route('admin.settings') }}">
                                        <i class="ti-settings"></i>Settings
                                    </a>
                                @endif

                                <form id="front-logout-form" action="{{ route('admin.logout',['source'=>'front']) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                                <a href="javascript:;" onclick="event.preventDefault();document.getElementById('front-logout-form').submit();">
                                    <i class="ti-power-off"></i>Logout
                                </a>

                            </div>

                        </div>

                        @endauth

                    </div>
                </nav>

            </div>
        </header>

        {{-- main content --}}
        <section class="section">
            <div class="container">

                @yield('content')

            </div>
        </section>

        {{-- Footer --}}
        <footer class="section-sm pb-0 border-top border-default">
            <div class="container">
                <div class="row justify-content-between">

                {{-- meta descrition & image --}}
                <div class="col-md-3 mb-4">
                    <a class="mb-4 d-block" href="/">
                        <img class="img-fluid" width="150px" src="/images/site/{{ isset(settings()->site_logo) ? settings()->site_logo : '' }}" alt="{{ isset(settings()->site_title) ? settings()->site_title : '' }}">
                    </a>
                    <p>
                        {{ isset(settings()->site_meta_description) ? settings()->site_meta_description : '' }}
                    </p>
                </div>

                {{-- Quick Links --}}
                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <h6 class="mb-4">Quick Links</h6>
                    <ul class="list-unstyled footer-list">
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        @foreach (get_pages('footer') as $page )
                            {{-- <li><a href="{{ route('show_page',$page->slug) }}">{{ $page->title }}</a></li> --}}
                        @endforeach
                    </ul>
                </div>

                {{-- Social Links --}}
                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <h6 class="mb-4">Social Links</h6>
                    <ul class="list-unstyled footer-list">

                        @if ( site_social_links()->facebook_url )
                            <li>
                                <a target="_blank" href="{{ site_social_links()->facebook_url }}">Facebook</a>
                            </li>
                        @endif

                        @if ( site_social_links()->twitter_url )
                            <li>
                                <a target="_blank" href="{{ site_social_links()->twitter_url }}">Twitter</a>
                            </li>
                        @endif

                        @if ( site_social_links()->instagram_url )
                            <li>
                                <a target="_blank" href="{{ site_social_links()->instagram_url }}">Instagram</a>
                            </li>
                        @endif

                        @if ( site_social_links()->linkedin_url )
                            <li>
                                <a target="_blank" href="{{  site_social_links()->linkedin_url }}">Linkedin</a>
                            </li>
                        @endif

                    </ul>
                </div>

                {{-- Newsletter --}}
                <div class="col-md-3 mb-4">
                    <h6 class="mb-4">Subscribe Newsletter</h6>
                    @livewire('newsletter-form')
                </div>

                </div>

                {{-- scroll-top --}}
                <div class="scroll-top">
                <a href="javascript:void(0);" id="scrollTop">
                    <i class="ti-angle-up"></i>
                </a>
                </div>

                {{-- Copyright info --}}
                <div class="text-center">
                    <p class="content">&copy; {{ date('Y') }} - Design &amp; Developed By <a href="#">Michael D. Butler</a></p>
                </div>

            </div>
        </footer>


        <script src="/front/plugins/jQuery/jquery.min.js"></script>
        <script src="/front/plugins/bootstrap/bootstrap.min.js" async></script>
        <script src="/front/plugins/slick/slick.min.js"></script>
        <script src="/extra-assets/ijabo/js/ijabo.min.js"></script>
        <script src="/front/js/script.js"></script>

        <script>
            window.addEventListener('showToastr', function(event){
                $().notifa({
                    vers:2,
                    cssClass:event.detail[0].type,
                    html:event.detail[0].message,
                    delay:2500
                });
            });
        </script>

        <script>
            //Toggle dropdown menu
            document.querySelector('.user-details').addEventListener('click', function(){
                this.classList.toggle('active');
            });
            //Close dropdown if user click outside
            document.addEventListener('click', function(e){
                const userDetails = document.querySelector('.user-details');
                if( !userDetails.contains(e.target) ){
                    userDetails.classList.remove('active');
                }
            });
        </script>

        @stack('scripts')

    </body>

</html>
