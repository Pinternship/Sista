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
    <!--/ bradcam_area  -->

    <div class="new-registration-page py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="register-account-box box p-3">
                        <h2>@lang('app.job_seeker')</h2>
                        <p class="icon"><i class="la la-user"></i> </p>
                        <p>@lang('app.job_seeker_new_desc')</p>
                        <a href="{{route('auth_google')}}" class="btn btn-success"><i class="la la-google"></i> @lang('app.google_login') </a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="register-account-box box  p-3">
                        <h2>@lang('app.employer')</h2>
                        <p class="icon"><i class="la la-black-tie"></i> </p>
                        <p>@lang('app.employer_new_desc')</p>
                        <a href="{{route('register_employer')}}" class="btn btn-success"><i class="la la-user-plus"></i> @lang('app.register_account') </a>
                    </div>
                </div>

                {{-- <div class="col-md-4">
                    <div class="register-account-box jf-shadow  p-3">
                        <h2>@lang('app.agency')</h2>
                        <p class="icon"><i class="la la-user-secret"></i> </p>
                        <p>@lang('app.agency_new_desc')</p>
                        <a href="{{route('register_agent')}}" class="btn btn-success"><i class="la la-user-plus"></i> @lang('app.register_account') </a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
