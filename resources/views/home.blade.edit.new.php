@extends('layouts.theme')

@section('content')

    <div class="home-hero-section">



        <div class="job-search-bar">

            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h1>@lang('app.sista')</h1>
                        <p>@lang('app.sista_long')</p>
                        <p class="mt-4 mb-4 job-search-sub-text">More than {!! $total_jobs !!}+ trusted jobs available from {!! $total_companys !!}+ different companys, <br /> on this website to take your career next level</p>
                    </div>
                </div>

                <div class="row ">
                    <div class="col-md-12">

                        <form action="{{route('jobs_listing')}}" class="form-inline" method="get">
                            <div class="form-row">
                                <div class="col-auto">

                                    <input type="text" name="q" class="form-control mb-2" style="min-width: 300px;" placeholder="@lang('app.job_title_placeholder')">
                                    <input type="text" name="location" class="form-control" style="min-width: 300px;"  placeholder="@lang('app.job_location_placeholder')">
                                    <button type="submit" class="btn btn-success mb-2"><i class="la la-search"></i> @lang('app.search') @lang('app.job')</button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>

        </div>

    </div>

    <div class="job-stats-footer bg-white pb-5 pt-5 text-center">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-muted mb-3">Our website stats</h2>
                    <p class="text-muted mb-4">Here the stats of how many people we've helped them to find jobs, hired talents</p>

                </div>
            </div>

            <section class="numbers">
                <div class="row">
                        <div class="col-md-3">
                            <h3 class="value">{!! $total_applys !!}</span>
                            <h5>Job Applicants</h5>
                        </div>

                        <div class="col-md-3">
                            <h3 class="value">{!! $total_jobs !!}</h3>
                            <h5>Job Posted</h5>
                        </div>

                        <div class="col-md-3">
                            <h3 class="value">{!! $total_users !!}</h3>
                            <h5>Active Users</h5>
                        </div>

                        <div class="col-md-3">
                            <h3 class="value">{!! $total_companys !!}</h3>
                            <h5>Companys</h5>
                        </div>
                </div>
            </section>
        </div>
    </div>

    @if($premium_jobs->count())
        <div class="premium-jobs-wrap pb-5 pt-5">

            <div class="card-container">

                <div class="row">
                    <div class="col-md-12">
                        <h4 class="mb-3">@lang('app.premium_jobs')</h4>
                    </div>
                </div>

                <div class="row">
                    @foreach($premium_jobs as $job)
                        <div class="col-md-4 mb-3">
                            <div class="premium-job-box p-3 bg-white">

                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="premium-job-logo">
                                            <a href="{{route('jobs_by_employer', $job->employer->company_slug)}}">
                                                <img src="{{$job->employer->logo_url}}" class="img-fluid" />
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-md-8 col-sm-6">

                                        <p class="premium-job-job-title">
                                            <a href="{{route('job_view', $job->job_slug)}}">{!! $job->job_title !!}</a>
                                        </p>
                                        <p class="premium-job-job-company">
                                            <a href="{{route('jobs_by_employer', $job->employer->company_slug)}}" class="text-muted">
                                                {{$job->employer->company}}
                                            </a>
                                        </p>

                                        {{-- <span class="badge badge-view">
                                            <i class="la la-eye"></i>
                                            @if($job->views)
                                                {!! $job->views !!}
                                            @else
                                                0
                                            @endif
                                        </span> --}}

                                        <p class="text-muted m-0">
                                            @lang('app.job_vacancy') {!! $job->vacancy !!}
                                        </p>

                                        <p class="text-muted m-0">
                                        @if($job->applyed)
                                            @lang('app.job_applied') {!! $job->applyed !!}
                                        @else
                                            @lang('app.job_applied') 0
                                        @endif
                                        </p>

                                        <p class="text-muted m-0">
                                            <i class="la la-map-marker"></i>
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
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>

            </div>

        </div>
    @endif

    @if($categories->count())
        <div class="home-categories-wrap bg-white pb-5 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="mb-3">@lang('app.browse_category')</h4>
                    </div>
                </div>

                <div class="row">

                    @foreach($categories as $category)
                        <div class="col-md-4">

                            <p>
                                <a href="{{route('jobs_listing', ['category' => $category->id])}}" class="category-link"><i class="la la-th-large"></i> {{$category->category_name}} <span class="text-muted">({{$category->job_count}})</span> </a>
                            </p>

                        </div>

                    @endforeach

                </div>

            </div>
        </div>
    @endif

    @if($regular_jobs->count())
        <div class="regular-jobs-wrap pb-5 pt-5">

            <div class="container">
                <div class="regular-job-container p-3">

                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb-3">@lang('app.new_jobs')</h4>
                        </div>
                    </div>

                    <div class="row">
                        @foreach($regular_jobs as $regular_job)
                            <div class="col-md-4 mb-3">

                                <div class="row">
                                    <div class="col-md-12">

                                        <p class="job-title m-0">
                                            <a href="{{route('job_view', $regular_job->job_slug)}}">{!! $regular_job->job_title !!}</a>
                                        </p>

                                        <p class="text-muted  m-0">
                                            <i class="la la-map-marker"></i>
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
                                </div>

                            </div>

                        @endforeach

                    </div>


                </div>

            </div>


        </div>
    @endif

    <div class="new-registration-page bg-white pb-5 pt-5">
        <div class="container">
            <div class="row">

                <div class="col-md-12">

                    <div class="call-to-action-post-job justify-content-center">
                        <div class="job-post-icon my-auto">
                            <img src="{{asset('assets/images/job.png')}}" />
                        </div>
                        <div class="job-post-details mr-3 ml-3 p-3 my-auto">
                            <h1>Post your job</h1>
                            <p>
                                Job seekers looking for quality job always. <br /> Post your job to get the talents
                            </p>
                        </div>

                        <div class="job-post-button my-auto">
                            <a href="{{route('post_new_job')}}" class="btn btn-success btn-lg">Post a Job</a>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="home-blog-section pb-5 pt-5">
        <div class="container">

            <div class="row">
                <div class="col-md-12">

                    <div class="pricing-section-heading mb-5 text-center">
                        <h1>From Our Blog</h1>
                        <h5 class="text-muted">Check the latest updates/news from us.</h5>
                    </div>

                </div>
            </div>


            <div class="row">

                @foreach($blog_posts as $post)

                    <div class="col-md-4">

                        <div class="blog-card-wrap bg-white p-3 mb-4">

                            <div class="blog-card-img mb-4">
                                <img src="{{$post->feature_image_thumb_uri}}" class="card-img" />
                            </div>

                            <h4 class="mb-3">{{$post->title}}</h4>

                            <p class="blog-card-text-preview">{!! limit_words($post->post_content) !!}</p>

                            <a href="{{route('blog_post_single', $post->slug)}}" class="btn btn-success"> <i class="la la-book"></i> Read More</a>

                            <div class="blog-card-footer border-top pt-3 mt-3">
                                <span><i class="la la-user"></i> {{$post->author->name}} </span>
                                <span><i class="la la-clock-o"></i> {{$post->created_at->diffForHumans()}} </span>
                                <span><i class="la la-eye"></i> {{$post->views}} </span>
                            </div>
                        </div>


                    </div>

                @endforeach

            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="home-all-blog-posts-btn-wrap text-center my-3">

                        <a href="" class="btn btn-success btn-lg"><i class="la la-link"></i> @lang('app.all_blog_posts')</a>

                    </div>
                </div>
            </div>


        </div>
    </div>


@endsection
