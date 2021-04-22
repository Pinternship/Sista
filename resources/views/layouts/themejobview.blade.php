<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{!! !empty($title) ? $title : 'JobFair' !!}</title>

    <!-- Scripts -->
    <script src={{ asset("assets/js/home/nice-select.min.js") }} ></script>
    <script src="{{ asset('js/app.js') }}"> </script>

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.png')}}">
    <!-- Place favicon.ico in the root directory -->

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/home/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/costume.css') }}">

    <script type='text/javascript'>
        /* <![CDATA[ */
        var page_data = {!! pageJsonData() !!};
        /* ]]> */
    </script>

</head>
<body class="{{request()->routeIs('home') ? ' home ' : ''}} {{request()->routeIs('job_view') ? ' job-view-page ' : ''}}">
    <!-- header-start -->
    @guest
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid ">
                    <div class="header_bottom_border">
                        <div class="row align-items-center">
                            <div class="col-xl-3 col-lg-2">
                                <div class="logo">
                                    <a class="navbar-brand" href="{{ url('/') }}">
                                        <img src="{{asset('assets/images/sistalogo1.png')}}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-7">
                                <div class="main-menu  d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="{{route('home')}}">home</a></li>
                                            <li><a href="{{route('jobs_listing')}}">Browse Job</a></li>
                                            <li><a href="#">Guide <i class="far fa-angle-down"></i></a>
                                                <ul class="submenu">
                                                    <li><a href="{{route('jobs_listing')}}">For Post Job </a></li>
                                                    <li><a href="{{route('jobs_listing')}}">For Apply </a></li>
                                                </ul>
                                            </li>
                                            <?php
                                            $header_menu_pages = config('header_menu_pages');
                                            ?>
                                            @if($header_menu_pages->count() > 0)
                                                @foreach($header_menu_pages as $page)
                                                    <li><a href="{{ route('single_page', $page->slug) }}">{{ $page->title }}</a></li>
                                                @endforeach
                                            @endif
                                            <li><a href="{{route('blog_index')}}">Blog</a></li>

                                            <li><a href="{{route('contact_us')}}">Contact</a></li>
                                            <li> <a href="{{ route('login') }}">{{ __('app.login') }}</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 d-none d-lg-block">
                                <div class="Appointment">
                                    {{-- <div class="phone_num d-none d-xl-block">

                                    </div> --}}
                                    <div class="d-none d-lg-block">
                                        <a class="boxed-btn3" href="{{route('post_new_job')}}"><i class="far fa-share-square"></i> {{__('app.post_new_job')}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Authentication Links -->
    @else
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid ">
                    <div class="header_bottom_border">
                        <div class="row align-items-center">
                            <div class="col-xl-3 col-lg-2">
                                <div class="logo">
                                    <a class="navbar-brand" href="{{ url('/') }}">
                                        <img src="{{asset('assets/images/sistalogo1.png')}}" alt=""">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-7">
                                <div class="main-menu  d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="{{route('home')}}">home</a></li>
                                            <li><a href="{{route('jobs_listing')}}">Browse Job</a></li>
                                            <li><a href="#">Guide <i class="far fa-angle-down"></i></a>
                                                <ul class="submenu">
                                                    <li><a href="{{route('jobs_listing')}}">For Post Job </a></li>
                                                    <li><a href="{{route('jobs_listing')}}">For Apply </a></li>
                                                </ul>
                                            </li>
                                            <?php
                                            $header_menu_pages = config('header_menu_pages');
                                            ?>
                                            @if($header_menu_pages->count() > 0)
                                                @foreach($header_menu_pages as $page)
                                                    <li><a href="{{ route('single_page', $page->slug) }}">{{ $page->title }}</a></li>
                                                @endforeach
                                            @endif
                                            <li><a href="{{route('blog_index')}}">Blog</a></li>

                                            <li><a href="{{route('contact_us')}}">Contact</a></li>

                                            <li>
                                                <a href="#"><i class="la la-user"></i> {{ Auth::user()->name }}
                                                    <span class="badge badge-warning"><i class="la la-briefcase"></i>{{auth()->user()->premium_jobs_balance}}</span>
                                                    <span class="caret"></span><i class="far fa-angle-down"></i>
                                                </a>
                                                <ul class="submenu">
                                                    <li><a class="dropdown-item" href="{{route('dashboard')}}">{{__('app.dashboard')}} </a></li>
                                                    <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                            {{ __('Logout') }}
                                                        </a>

                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                            @csrf
                                                        </form>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @endguest
    <!-- header-end -->

    <div id="app">
        <div class="main-container">
            @yield('content')
        </div>

    <!-- footer start -->
    <footer class="footer">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-lg-3">
                        <div class="footer_widget wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                            <div class="footer_logo">
                                <a href="{{ url('/') }}">
                                    <img src="{{asset('assets/images/sistalogo1.png')}}" alt="">
                                </a>
                            </div>
                            <p>
                                sscc@unika.ac.id <br>
                                024-8441555, 8505003 Ext. 1430,1431 <br>
                                081227918717 <br>
                                Jl. Pawiyatan Luhur IV/1 <br>
                                Bendan Dhuwur, Semarang 50234 <br>
                                Mikael Building, 2nd floor.
                            </p>
                            <div class="socail_links">
                                <ul>
                                    <li>
                                        <a href="https://www.facebook.com/public/Sscc-Unika-Soegijapranata" target="_blank">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="http://www.unika.ac.id/sscc/" target="_blank">
                                            <i class="far fa-browser"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/ssccunikasoegijapranata/?hl=en" target="_blank">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-2 col-md-6 col-lg-2">
                        <div class="footer_widget wow fadeInUp" data-wow-duration="1.1s" data-wow-delay=".4s">
                            <h3 class="footer_title">
                                Company
                            </h3>
                            <ul>
                                <li><a href="{{route('blog_post_single', 'company-manual')}}">@lang('app.create_account')</a> </li>
                                <li><a href="{{route('post_new_job')}}">@lang('app.post_new_job')</a> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget wow fadeInUp" data-wow-duration="1.2s" data-wow-delay=".5s">
                            <h3 class="footer_title">
                                Joob Seeker
                            </h3>
                            <ul>
                                <li><a href="{{route('auth_google')}}">@lang('app.google_login')</a> </li>
                                <li><a href="{{route('jobs_listing')}}">@lang('app.search_jobs')</a> </li>
                                <li><a href="{{route('applied_jobs')}}">@lang('app.applied_jobs')</a> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-4">
                        <div class="footer_widget wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".6s">
                            <h3 class="footer_title">
                                SISTA
                            </h3>
                            <?php
                            $show_in_footer_menu = config('footer_menu_pages');
                            ?>
                            @if($show_in_footer_menu->count() > 0)
                                @foreach($show_in_footer_menu as $page)
                                    <li><a href="{{ route('single_page', $page->slug) }}">{{ $page->title }} </a></li>
                                @endforeach
                            @endif
                            <li><a href="{{route('contact_us')}}">@lang('app.contact_us')</a> </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy-right_text wow fadeInUp" data-wow-duration="1.4s" data-wow-delay=".3s">
            <div class="container">
                <div class="footer_border"></div>
                <div class="row">
                    <div class="col-xl-12">
                        <p class="copy_right text-center">
                            {!! get_text_tpl(get_option('copyright_text')) !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--/ footer end  -->
</div>


<!-- Scripts -->
@yield('page-js')
<!-- link that opens popup -->
<!-- JS here -->
<script src={{ asset("assets/js/home/vendor/modernizr-3.5.0.min.js") }}></script>
<script src={{ asset("assets/js/home/vendor/jquery-1.12.4.min.js") }}></script>
<script src={{ asset("assets/js/home/popper.min.js") }}></script>
<script src={{ asset("assets/js/home/bootstrap.min.js") }}></script>
<script src={{ asset("assets/js/home/owl.carousel.min.js") }}></script>
<script src={{ asset("assets/js/home/isotope.pkgd.min.js") }}></script>
<script src={{ asset("assets/js/home/ajax-form.js") }} ></script>
<script src={{ asset("assets/js/home/waypoints.min.js") }} ></script>
<script src={{ asset("assets/js/home/jquery.counterup.min.js") }} ></script>
<script src={{ asset("assets/js/home/imagesloaded.pkgd.min.js") }} ></script>
<script src={{ asset("assets/js/home/scrollIt.js") }} ></script>
<script src={{ asset("assets/js/home/jquery.scrollUp.min.js") }} ></script>
<script src={{ asset("assets/js/home/wow.min.js") }} ></script>
<script src={{ asset("assets/js/home/jquery.slicknav.min.js") }} ></script>
<script src={{ asset("assets/js/home/jquery.magnific-popup.min.js") }} ></script>
<script src={{ asset("assets/js/home/plugins.js") }} ></script>
<script src={{ asset("assets/js/home/gijgo.min.js") }} ></script>



<!--contact js-->
<script src={{ asset("assets/js/home/contact.js") }}></script>
<script src={{ asset("assets/js/home/jquery.ajaxchimp.min.js") }}></script>
<script src={{ asset("assets/js/home/jquery.form.js") }}></script>
<script src={{ asset("assets/js/home/jquery.validate.min.js") }}></script>
<script src={{ asset("assets/js/home/mail-script.js") }}></script>


<script src="{{ asset('assets/js/home/main.js') }}" defer></script>
<script src="{{ asset('assets/js/main.js') }}" defer></script>

</body>
</html>
