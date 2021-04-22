@extends('layouts.dashboard')


@section('content')
    <!-- BEGIN: Profile Info -->
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-gray-200 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    @if($user->google_id != NULL)
                        <img  class="rounded-full" src="{{$user->photo}}">
                    @else
                        <img class="rounded-full" src="{{$user->logo_url}}">
                    @endif
                </div>
                <div class="ml-5">
                    <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{$user->name}}</div>
                    <div class="text-gray-600">{{$user->company}}</div>
                </div>
            </div>

            @if(!$user->is_faculty())
                @if($user->google_id != NULL)
                        <div class="flex mt-6 lg:mt-0 items-center lg:items-start flex-1 flex-col justify-center text-gray-600 px-5 border-l border-r border-gray-200 border-t lg:border-t-0 pt-5 lg:pt-0">
                        <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="mail" class="w-4 h-4 mr-2"></i> {{$user->email}} </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="phone" class="w-4 h-4 mr-2"></i>{{$user->phone}}</a></div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="map-pin" class="w-4 h-4 mr-2"></i> {{$user->address}} </div>
                    </div>
                @else
                    <div class="flex mt-6 lg:mt-0 items-center lg:items-start flex-1 flex-col justify-center text-gray-600 px-5 border-l border-r border-gray-200 border-t lg:border-t-0 pt-5 lg:pt-0">
                        <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="mail" class="w-4 h-4 mr-2"></i> {{$user->email}} </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="link" class="w-4 h-4 mr-2"></i> <a href="{{$user->website}}"> {{$user->website}} </a></div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="phone" class="w-4 h-4 mr-2"></i>{{$user->phone}}</a></div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="map-pin" class="w-4 h-4 mr-2"></i> {{$user->address}} -  {{$user->address2}} - {{$user->city}}</div>
                    </div>
                 @endif
                <div class="mt-6 lg:mt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-0 border-gray-200 pt-5 lg:pt-0">
                    @if($user->google_id != NULL)
                        <div class="text-center rounded-md w-20 py-3">
                            <div class="font-semibold text-theme-1 text-lg">{{$totalApplicants_user}}</div>
                            <div class="text-gray-600">Total Apply</div>
                        </div>
                        <div class="text-center rounded-md w-20 py-3">
                            <div class="font-semibold text-theme-1 text-lg">{{$totalJobActive}}</div>
                            <div class="text-gray-600">Status Jobs</div>
                        </div>
                    @else
                        <div class="text-center rounded-md w-20 py-3">
                            <div class="font-semibold text-theme-1 text-lg">{{$totalJob}}</div>
                            <div class="text-gray-600">Total Jobs</div>
                        </div>
                        <div class="text-center rounded-md w-20 py-3">
                            <div class="font-semibold text-theme-1 text-lg">{{$totalJobActive}}</div>
                            <div class="text-gray-600">Active Jobs</div>
                        </div>
                        <div class="text-center rounded-md w-20 py-3">
                            <div class="font-semibold text-theme-1 text-lg">{{$totalJobView}}</div>
                            <div class="text-gray-600">Total Job View</div>
                        </div>
                        <div class="text-center rounded-md w-20 py-3">
                            <div class="font-semibold text-theme-1 text-lg">{{$totalApplicants}}</div>
                            <div class="text-gray-600">Applicants</div>
                        </div>   
                    @endif
                </div>
            @endif
        </div>
        <div class="nav-tabs flex flex-col sm:flex-row justify-center lg:justify-start">
            <a data-toggle="tab" data-target="{{route('dashboard')}}" href="{{route('dashboard')}}" class="py-4 sm:mr-8">Dashboard</a>

            @if($user->is_faculty())
                <a data-toggle="tab" data-target="{{route('dashboard_premium_data')}}" href="{{route('dashboard_premium_data')}}" class="py-4 sm:mr-8">Faculty Data</a>
            @else
                <a data-toggle="tab" data-target="{{route('dashboard_premium_data')}}" href="{{route('dashboard_premium_data')}}" class="py-4 sm:mr-8">Premium Data</a>
            @endif

            <a data-toggle="tab" data-target="{{route('profile')}}" href="{{route('profile')}}" class="py-4 sm:mr-8 active">Account & Profile</a>
            <a data-toggle="tab" data-target="{{route('employer_profile')}}" href="{{route('employer_profile')}}" class="py-4 sm:mr-8">Edit Profile</a>
        </div>
        </div>
    <!-- END: Profile Info -->
    <div class="intro-y tab-content mt-5">
        <div class="tab-content__pane active" id="dashboard">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Statistic -->
                <div class="intro-y box col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
                        <h2 class="font-medium text-base mr-auto">
                            Profile
                        </h2>
                    </div>
                    <div class="p-5">
                            <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                                <div class="mb-2">@lang('app.name')</div>
                                <input type="text" class="input w-full border flex-1" id="company" value="{{ $user->name }}" readonly>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                                <div class="mb-2">@lang('app.email')</div>
                                <input type="text" class="input w-full border flex-1" id="company" value="{{ $user->email }}" readonly>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                                <div class="mb-2">@lang('app.gender')</div>
                                <input type="text" class="input w-full border flex-1" id="company" value="{{ ucfirst($user->gender) }}" readonly>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                                <div class="mb-2">@lang('app.phone')</div>
                                <input type="text" class="input w-full border flex-1" id="company" value="{{ $user->phone }}" readonly>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                                <div class="mb-2">@lang('app.address')</div>
                                <input type="text" class="input w-full border flex-1" id="company" value="{{ $user->address }}" readonly>
                            </div>
                            @if($user->country)
                                <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                                    <div class="mb-2">@lang('app.country')</div> 
                                    <input type="text" class="input w-full border flex-1" id="company" value="{{ $user->country->name }}" readonly>
                                </div>
                                 @endif
                                <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                                    <div class="mb-2">@lang('app.created_at')</div>
                                    <input type="text" class="input w-full border flex-1" id="company" value="{{ $user->signed_up_datetime() }}" readonly>
                                </div>
                                <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                                    <div class="mb-2">@lang('app.status')</div>
                                    <input type="text" class="input w-full border flex-1" id="company" value="{{ $user->status_context() }}" readonly>
                                </div>

                            @if($user->is_employer() || $user->is_agent())
                                <h3 class="mb-4">About Company</h3>
                                <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                                    <div class="mb-2">@lang('app.state')</div>
                                    <input type="text" class="input w-full border flex-1" id="company" value="{{ $user->state_name }}" readonly>
                                </div>
                                <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                                    <div class="mb-2">@lang('app.city')</div>
                                    <input type="text" class="input w-full border flex-1" id="company" value="{{ $user->city }}" readonly>
                                </div>
                                <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                                    <div class="mb-2">@lang('app.website')</div>
                                    <input type="text" class="input w-full border flex-1" id="company" value="{{ $user->website }}" readonly>
                                </div>
                                <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                                    <div class="mb-2">@lang('app.company')</div>
                                    <input type="text" class="input w-full border flex-1" id="company" value="{{ $user->company }}" readonly>
                                </div>
                                @if ($user->company_size != null)
                                    <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                                        <div class="mb-2">@lang('app.company_size')</div>
                                        <input type="text" class="input w-full border flex-1" id="company" value="{{company_size($user->company_size)}}" readonly>
                                    </div>
                                @endif
                                <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                                    <div class="mb-2">@lang('app.about_company')</div>
                                    <input type="text" class="input w-full border flex-1" id="company" value="{{ $user->about_company }}" readonly>
                                </div>
                                <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                                    <div class="mb-2">@lang('app.premium_jobs_balance')</div>
                                    <input type="text" class="input w-full border flex-1" id="company" value="{{ $user->premium_jobs_balance }}" readonly>
                                </div>
                            @endif
                    </div>
                </div>
                <!-- END: General Statistic -->
            </div>
        </div>
    </div>
@endsection