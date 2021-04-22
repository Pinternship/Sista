@extends('layouts.theme')

@section('content')

    <!-- bradcam_area  -->
    <div class="bradcam_area bradcam_bg_1">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text">
                        {{-- <h3>{!! !empty($title) ? $title : 'JobFair' !!}</h3> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ bradcam_area  -->

    <div class="blog-single-page bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="blog-single-title mt-5">
                        <h1 style="font-size: 30px;font-weight: 400;text-transform: capitalize;">{{$page->title}}</h1>
                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="blog-single-content pt-3 pb-5">
                        {!! $page->post_content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
