@extends('layouts.theme')

@section('content')
    <!-- bradcam_area  -->
    <div class="bradcam_area bradcam_bg_1">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text">
                        <h3 style="font-size: 56px;font-weight: 400;text-transform: capitalize;">{!! !empty($title) ? $title : 'JobFair' !!}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="checkout-page bg-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">


                    <h1 class="mb-4">{{$title}}</h1>
                    <h4 class="mb-4">{{$msg}}</h4>


                    <a href="" class="btn btn-outline-secondary btn-lg"> <i class="la la-home"></i> @lang('app.go_to_home')</a>

                </div>
            </div>
        </div>
    </div>
@endsection