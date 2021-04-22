@extends('layouts.dashboard')

@section('page-css')
@endsection

@section('content')
    <!-- BEGIN: Profile Info -->
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-gray-200 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    <img alt="Midone Tailwind HTML Admin Template" class="rounded-full" src="{{$user->logo_url}}">
                </div>
                <div class="ml-5">
                    <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{$user->name}}</div>
                    <div class="text-gray-600">{{$user->company}}</div>
                </div>
            </div>
            <div class="flex mt-6 lg:mt-0 items-center lg:items-start flex-1 flex-col justify-center text-gray-600 px-5 border-l border-r border-gray-200 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="mail" class="w-4 h-4 mr-2"></i> {{$user->email}} </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="link" class="w-4 h-4 mr-2"></i> <a href="{{$user->website}}"> {{$user->website}} </a></div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="phone" class="w-4 h-4 mr-2"></i>{{$user->phone}}</a></div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="map-pin" class="w-4 h-4 mr-2"></i> {{$user->address}} -  {{$user->address2}} - {{$user->city}}</div>
            </div>
            <div class="mt-6 lg:mt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-0 border-gray-200 pt-5 lg:pt-0">
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
            </div>
        </div>
        <div class="nav-tabs flex flex-col sm:flex-row justify-center lg:justify-start">
            <a data-toggle="tab" data-target="{{route('dashboard')}}" href="{{route('dashboard')}}" class="py-4 sm:mr-8">Dashboard</a>
            <a data-toggle="tab" data-target="{{route('dashboard_premium_data')}}" href="{{route('dashboard_premium_data')}}" class="py-4 sm:mr-8">Premium Data</a>
            <a data-toggle="tab" data-target="{{route('profile')}}" href="{{route('profile')}}" class="py-4 sm:mr-8">Account & Profile</a>
            <a data-toggle="tab" data-target="{{route('employer_profile')}}" href="{{route('employer_profile')}}" class="py-4 sm:mr-8 active">Edit Profile</a>
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
                            Edit Profile
                        </h2>
                    </div>
                    <div class="p-5">
                        <form method="post" action="" enctype="multipart/form-data">
                        @csrf
                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('company')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.company') <font color="red">*</font></div>
                                <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('company', $errors)}}" id="company" value="{{ $user->company }}" name="company" placeholder="@lang('app.company')" required>
                                <p style="color: #ff0000">{!! e_form_error('company', $errors) !!}
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('company_size')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.company_size')</div>
                                <select class="input w-full border flex-1 {{e_form_invalid_class('company_size', $errors)}}" name="company_size" id="salary_cycle">
                                    @foreach(company_size() as $size => $size_name)
                                        <option value="{{$size}}" {{selected($size, $user->company_size)}} >{{$size_name}}</option>
                                    @endforeach
                                </select>
                                {!! e_form_error('company_size', $errors) !!}
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('country')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.country')</div>
                                    <select name="country" class="input w-full border flex-1 {{e_form_invalid_class('country', $errors)}} country_options">
                                        <option value="">Select a state</option>
                                        @foreach($countries as $country)
                                             <option value="{!! $country->id !!}" {{selected($country->id, $user->country_id)}}  >{!! $country->country_name !!}</option>
                                        @endforeach
                                    </select>
                                    {!! e_form_error('country', $errors) !!}
                            </div>


                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('state')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.state')</div>
                                    <select name="state" class="input w-full border flex-1 {{e_form_invalid_class('state', $errors)}} state_options">
                                        <option value="">Select a state</option>
                                        @if($old_country)
                                            @foreach($old_country->states as $state)
                                                <option value="{{$state->id}}" {{selected($state->id, $user->state_id)}}>{!! $state->state_name !!}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    {!! e_form_error('state', $errors) !!}
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('city')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.city_name')</div>
                                <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('city', $errors)}}" id="city" value="{{$user->city}}" name="city" placeholder="@lang('app.city_name')">
                                {!! e_form_error('city', $errors) !!}
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('address')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.address') <font color="red">*</font></div>
                                <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('address', $errors)}}" id="address" value="{{ $user->address }}" name="address" placeholder="@lang('app.address')">
                                <p style="color: #ff0000">{!! e_form_error('address', $errors) !!}
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('address_2')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.address_2')</div>
                                <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('address_2', $errors)}}" id="address_2" value="{{ $user->address_2 }}" name="address_2" placeholder="@lang('app.address_2')">
                                <p style="color: #ff0000">{!! e_form_error('address_2', $errors) !!}
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('phone')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.phone') <font color="red">*</font></div>
                                <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('phone', $errors)}}" id="phone" value="{{ $user->phone }}" name="phone" placeholder="@lang('app.phone')">
                                <p style="color: #ff0000">{!! e_form_error('phone', $errors) !!}
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('about_company')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.about_company')</div>
                                    <textarea name="about_company" class="input w-full border flex-1  {{e_form_invalid_class('about_company', $errors)}}" rows="5">{!! $user->about_company !!}</textarea>
                                    {!! $errors->has('about_company')? '<p class="help-block">'.$errors->first('about_company').'</p>':'' !!}
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('website')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.website')</div>
                                    <input type="text"name="website" class="input w-full border flex-1  {{e_form_invalid_class('website', $errors)}}" value="{!! $user->website !!}">
                                    {!! $errors->has('website')? '<p class="help-block">'.$errors->first('website').'</p>':'' !!}
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('logo')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.logo')</div>
                                <input type="file" accept="image/x-png,image/gif,image/jpeg" class="input w-full border flex-1 {{e_form_invalid_class('logo', $errors)}}" id="logo" value="{{ $user->logo }}" name="logo" placeholder="@lang('app.logo')">
                                <p style="color: #ff0000">{!! e_form_error('logo', $errors) !!}
                            </div>

                            <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                                <button type="submit" class="button w-40 justify-center block bg-theme-1 text-white">@lang('app.edit')</button>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- END: General Statistic -->
            </div>
        </div>
    </div>

@endsection
@section('page-js')
@endsection