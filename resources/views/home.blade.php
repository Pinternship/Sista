<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{!! !empty($title) ? $title : 'JobFair' !!}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.png')}}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href={{ asset("assets/css/home/style.css") }}>
    <link rel="stylesheet" href={{ asset("assets/css/home/bootstrap.min.css") }}>
    <link rel="stylesheet" href={{ asset("assets/css/home/owl.carousel.min.css") }}>
    <link rel="stylesheet" href={{ asset("assets/css/home/magnific-popup.css") }}>
    <link rel="stylesheet" href={{ asset("assets/css/home/themify-icons.css") }}>
    <link rel="stylesheet" href={{ asset("assets/css/home/nice-select.css") }}>
    <link rel="stylesheet" href={{ asset("assets/css/home/flaticon.css") }}>
    <link rel="stylesheet" href={{ asset("assets/css/home/gijgo.css") }}>
    <link rel="stylesheet" href={{ asset("assets/css/home/animate.min.css") }}>
    <link rel="stylesheet" href={{ asset("assets/css/home/slicknav.css") }}>
    {{-- <link rel="stylesheet" href={{ asset("assets/css/home/responsive.css") }}> --}}

    <script type='text/javascript'>
        /* <![CDATA[ */
        var page_data = {!! pageJsonData() !!};
        /* ]]> */
    </script>

    {{-- PWA --}}
    @laravelPWA
</head>

<body>
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
                                        <img src="{{asset('assets/images/sistalogo1.png')}}" alt="">
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

                        {{-- <div class="main-menu  d-none d-lg-block">
                            <nav>
                                <ul id="navigation">
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
                        </div> --}}

    <!-- header-end -->

    <!-- slider_area_start -->
    <div class="slider_area">
        <div class="single_slider  d-flex align-items-center slider_bg_1">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-6">
                        <div class="slider_text">
                            <h5 class="wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".2s">@lang('app.sista')</h5>
                            <h2 class="wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s">@lang('app.sista_long')</h3>
                            <p class="wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".4s">More than {!! $total_jobs !!}+ trusted jobs available from {!! $total_companys !!}+ different companys, <br /> on this website to take your career next level</p>
                            <div class="sldier_btn wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".5s">
                                <a href="{{route('jobs_listing')}}" class="boxed-btn3">Browse Job</a>
                            </div>
                            {{-- {!! $responses !!} --}}
                                {{-- {!! $jsons[0] !!}
                                {!! $jsons[1] !!}
                                {!! $jsons[2] !!}
                                {!! $jsons[3] !!} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ilstration_img wow fadeInRight d-none d-lg-block text-right" data-wow-duration="1s" data-wow-delay=".2s">
            <img src="{{asset('assets/img/banner/illustration.png')}}" alt="">
        </div>
    </div>
    <!-- slider_area_end -->

    <!-- catagory_area -->
    <div class="catagory_area">
            <div class="container">
                <form action="{{route('jobs_listing')}}" method="get">
                    <div class="row cat_search">
                        <div class="col-lg-20 col-md-4">
                            <div class="single_input">
                                <input type="text" name="q" placeholder="@lang('app.job_title_placeholder')">
                            </div>
                        </div>
                        <div class="col-lg-20 col-md-4">
                            <div class="single_input">
                                <input type="text" name="location"  placeholder="@lang('app.job_location_placeholder')">
                            </div>
                        </div>
                        <div class="col-lg-auto col-md-12">
                            <div class="job_btn">
                                <button type="submit" class="boxed-btn3"><i class="far fa-search"></i> @lang('app.search') @lang('app.job')</button>
                            </div>
                        </div>
                    </div>
                </form>
            <div class="row">
                <div class="col-lg-12">
                    <div class="popular_search d-flex align-items-center">
                        <span>Popular Search:</span>
                        <ul>
                            @foreach($views as $view)
                                <li><a href="{{route('job_view', $view->job_slug)}}">{{ $view->job_title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ catagory_area -->

    {{-- Stats --}}
    {{-- <div class="catagory_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_title mb-40">
                        <h3>Our website stats</h3>
                        <p class="text-muted mb-4">Here the stats of how many people we've helped them to find jobs, hired talents</p>
                    </div>
                </div>
            </div>

            <section class="numbers">
                <div class="row">
                        <div class="col-lg-4 col-xl-3 col-md-6">
                            <h3 class="value">{!! $total_applys !!}</span>
                            <h5>Job Applicants</h5>
                        </div>

                        <div class="col-lg-4 col-xl-3 col-md-6">
                            <h3 class="value">{!! $total_jobs !!}</h3>
                            <h5>Job Posted</h5>
                        </div>

                        <div class="col-lg-4 col-xl-3 col-md-6">
                            <h3 class="value">{!! $total_users !!}</h3>
                            <h5>Active Users</h5>
                        </div>

                        <div class="col-lg-4 col-xl-3 col-md-6">
                            <h3 class="value">{!! $total_companys !!}</h3>
                            <h5>Companys</h5>
                        </div>
                </div>
            </section>
            </div>
        </div>
    </div> --}}

    <!-- popular_catagory_area_start  -->
    {{-- @if($categories->count())
        <div class="popular_catagory_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3>@lang('app.browse_category')</h3>
                    </div>
                </div>
                <div class="row">
                    @foreach($categories as $category)
                        <div class="col-md-4">
                            <p>
                                <a href="{{route('jobs_listing', ['category' => $category->id])}}" class="category-link"><i class="far fa-plus-square"></i> {{$category->category_name}} <span class="text-muted">({{$category->job_count}})</span> </a>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif --}}

    @if($categorie_tops->count())
    <div class="popular_catagory_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_title mb-40">
                        <h3>Popolar Categories</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($categorie_tops as $categorie_top)
                    <div class="col-lg-4 col-xl-3 col-md-6">
                        <div class="single_catagory">
                            <a href="{{route('jobs_listing', ['category' => $categorie_top->id])}}"><h4>{{$categorie_top->category_name}}</h4></a>
                            <p> <span>{{$categorie_top->job_count}}</span> Available position</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <!-- popular_catagory_area_end  -->

    <!-- job_listing_area_start  -->
    @if($premium_jobs->count())
    <div class="job_listing_area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="section_title">
                        <h3>@lang('app.premium_jobs')</h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="brouse_job text-right">
                        <a href="{{route('jobs_listing')}}" class="boxed-btn4">Browse More Job</a>
                    </div>
                </div>
            </div>
            <div class="job_lists">
                <div class="row">
                    @foreach($premium_jobs as $job)
                    <div class="col-lg-12 col-md-12">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                <div class="thumb">
                                    <img src="{{$job->employer->logo_url}}" alt="">
                                </div>
                                <div class="jobs_conetent">
                                    <a href="{{route('job_view', $job->job_slug)}}"><h4>{!! $job->job_title !!}</h4></a>
                                    <div class="links_locat d-flex align-items-center">
                                        @if($job->vacancy)
                                        <div class="location">
                                            <p> @lang('app.job_vacancy') {!! $job->vacancy !!} </p>
                                        </div>
                                        @endif
                                        @if($job->applyed)
                                        <div class="location">
                                            <p> @lang('app.job_applied') {!! $job->applyed !!} </p>
                                        </div>
                                        @endif
                                        @if ($job->is_any_where == 1)
                                            <div class="location">
                                                <p> <i class="fal fa-map-marker-alt"></i> @lang('app.anywhere') </p>
                                            </div>
                                        @else
                                            <div class="location">
                                                <p> <i class="fal fa-map-marker-alt"></i>
                                                    @if($job->city_name)
                                                        {!! $job->city_name !!},
                                                    @endif
                                                    @if($job->state_name)
                                                        {!! $job->state_name !!},
                                                    @endif
                                                    @if($job->state_name)
                                                        {!! $job->country_name !!}
                                                    @endif
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="jobs_right">
                                <div class="apply_now">
                                    <a class="heart_mark" href="{{route('jobs_by_employer', $job->employer->company_slug)}}">
                                        {{$job->employer->company}}
                                    </a>
                                    <a href="{{route('job_view', $job->job_slug)}}" class="boxed-btn3">Apply Now</a>
                                </div>
                                <div class="date">
                                    <p>Deadline: {{$job->deadline->format(get_option('date_format'))}} ( {{$job->deadline->diffForHumans()}} )</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- job_listing_area_end  -->

    <!-- featured_candidates_area_start  -->
    @if($regular_jobs->count())
    <div class="featured_candidates_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_title text-center mb-40">
                        <h3>@lang('app.new_jobs')</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="candidate_active owl-carousel">
                        @foreach($regular_jobs as $regular_job)
                        <div class="single_candidates text-center">
                            <div class="thumb">
                                <img src="{{ $regular_job->employer->logo_url }}" alt="{!! $regular_job->job_title !!}">
                            </div>
                            <a href="{{route('job_view', $regular_job->job_slug)}}"><h4>{!! $regular_job->job_title !!}</h4></a>
                            @if ($regular_job->is_any_where == 1)
                                <div class="location">
                                    <p> <i class="fal fa-map-marker-alt"></i> @lang('app.anywhere') </p>
                                </div>
                            @else
                                <div class="location">
                                    <p> <i class="fal fa-map-marker-alt"></i>
                                        @if($regular_job->city_name)
                                            {!! $regular_job->city_name !!},
                                        @endif
                                        @if($regular_job->state_name)
                                            {!! $regular_job->state_name !!},
                                        @endif
                                        @if($regular_job->state_name)
                                            {!! $regular_job->country_name !!}
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- featured_candidates_area_end  -->

    <div class="top_companies_area">
        <div class="container">
            <div class="row align-items-center mb-40">
                <div class="col-lg-6 col-md-6">
                    <div class="section_title">
                        <h3>Top Companies</h3>
                    </div>
                </div>
                {{-- <div class="col-lg-6 col-md-6">
                    <div class="brouse_job text-right">
                        <a href="jobs.html" class="boxed-btn4">Browse More Job</a>
                    </div>
                </div> --}}
            </div>
            <div class="row">
                @foreach($company_tops as $company_top)
                <div class="col-lg-4 col-xl-3 col-md-6">
                    <div class="single_company">
                        <div class="thumb">
                            <img src="{{ $company_top->employer->logo_url }}" alt="{{ $company_top->company }}">
                        </div>
                        <a href="{{route('jobs_by_employer', $company_top->employer->company_slug)}}"><h3>{{ $company_top->employer->company }}</h3></a>
                        <p> <span>{{ $company_top->jumlah }}</span> Applyed position</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- job_searcing_wrap  -->
    <div class="job_searcing_wrap overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 offset-lg-1 col-md-6">
                    <div class="searching_text">
                        <h3>Looking for a Job?</h3>
                        <p>We have {!! $total_jobs !!}+ jobs </p>
                        <a href="{{route('jobs_listing')}}" class="boxed-btn3">Browse Job</a>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1 col-md-6">
                    <div class="searching_text">
                        <h3>Looking for a Expert?</h3>
                        <p>We have {!! $total_user_googles !!}+ users</p>
                        <a href="{{route('post_new_job')}}" class="boxed-btn3">Post a Job</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- job_searcing_wrap end  -->

    <!-- testimonial_area  -->
    <div class="testimonial_area  ">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_title text-center mb-40">
                        <h3>Testimonial</h3>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="testmonial_active owl-carousel">
                        {{-- start here --}}
                        <div class="single_carousel">
                            <div class="row">
                                <div class="col-lg-11">
                                    <div class="single_testmonial d-flex align-items-center">
                                        <div class="thumb">
                                            <img src="{{asset('assets/img/testmonial/author.png')}}" alt="">
                                            <div class="quote_icon">
                                                <i class="fal fa-quote-right"></i>
                                            </div>
                                        </div>
                                        <div class="info">
                                            <p>"Working in conjunction with humanitarian aid agencies, we have supported programmes to help alleviate human suffering through animal welfare when people might depend on livestock as their only source of income or food.</p>
                                            <span>- Micky Mouse</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end here --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /testimonial_area  -->

    {{-- Blog --}}
    @if($blog_posts->count())
    <div class="featured_candidates_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_title text-center mb-40">
                        <h3>From Our Blog</h3>
                        <h5 class="text-muted">Check the latest updates/news from us.</h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="candidate_active owl-carousel">
                        @foreach($blog_posts as $post)
                            <div class="carddong">
                                <img src="{{$post->feature_image_thumb_uri}}" class="carddong-img-top" alt="...">
                                <div class="carddong-body">
                                    <p><i class="fal fa-clock"></i> {{$post->created_at->diffForHumans()}}</p>
                                    <a href="{{route('blog_post_single', $post->slug)}}"><h2 class="carddong-title c-link c-link--gray c-tooltip" aria-label="{{  $post->title  }}">{!! batas_judul($post->title) !!}</h2></a>
                                    <p class="carddong-text">{!! batas_isi($post->post_content) !!}</p>
                                </div>
                                <div class="carddong-body carddong-p">
                                    <div class="row">
                                        <div class="col-auto col-xs-4 ">
                                            <i class="fal fa-user"></i> {{$post->author->name}}
                                        </div>
                                        <div class="col-auto col-xs-4">
                                            <i class="fal fa-eye"></i> {{$post->views}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    {{-- End of Blog --}}

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
    <script src={{ asset("assets/js/home/nice-select.min.js") }} ></script>
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


    <script src={{ asset("assets/js/home/main.js") }}></script>
</body>

</html>
