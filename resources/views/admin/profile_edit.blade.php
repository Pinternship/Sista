@extends('layouts.dashboard')


@section('content')
<div class="intro-y box sm:py-20 mt-5">
    <div class="px-5 sm:px-20">
        <div class="font-medium text-base">@lang('app.profile_edit')</div>
            <div class="gap-4 mt-5">
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('name')? 'has-error':'' }}">
                <div class="mb-2">@lang('app.name')</div>
                <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('name', $errors)}}" id="name" value="{{ $user->name }}" name="name" placeholder="@lang('app.name')">
                <p style="color: #ff0000">{!! e_form_error('name', $errors) !!}
            </div>

            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('email')? 'has-error':'' }}">
                <div class="mb-2">@lang('app.email')</div>
                <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('email', $errors)}}" id="email" value="{{ $user->email }}" name="email" placeholder="@lang('app.email')">
                <p style="color: #ff0000">{!! e_form_error('email', $errors) !!}
            </div>

            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('gender')? 'has-error':'' }}">
                <div class="mb-2">@lang('app.gender')</div>
                <select class="input w-full border flex-1 {{e_form_invalid_class('gender', $errors)}}" name="gender" id="gender">
                    <option value="" {{selected(NULL, $user->gender)}}>Select Gender</option>
                    <option value="male"  {{selected('male', $user->gender)}}>@lang('app.male')</option>
                    <option value="female" {{selected('female', $user->gender)}}>@lang('app.female')</option>
                </select>
                {!! e_form_error('gender', $errors) !!}
            </div>


            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('phone')? 'has-error':'' }}">
                <div class="mb-2">@lang('app.phone')</div>
                <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('phone', $errors)}}" id="phone" value="{{ $user->phone }}" name="phone" placeholder="@lang('app.phone')">
                <p style="color: #ff0000">{!! e_form_error('phone', $errors) !!}
            </div>

            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('country')? 'has-error':'' }}">
                <div class="mb-2">@lang('app.country')</div>
                    <select name="country_id" id="country_id" class="input w-full border flex-1 {{e_form_invalid_class('country', $errors)}} country_options">
                        <option value="">@lang('app.select_a_country')</option>
                        @foreach($countries as $country)
                             <option value="{{ $country->id }}" {{ $user->country_id == $country->id ? 'selected' :'' }}>{{ $country->country_name }}</option>
                        @endforeach
                    </select>
                    {!! e_form_error('country_id', $errors) !!}
            </div>

            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('address')? 'has-error':'' }}">
                <div class="mb-2">@lang('app.address')</div>
                <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('address', $errors)}}" id="address" value="{{ $user->address }}" name="address" placeholder="@lang('app.address')">
                <p style="color: #ff0000">{!! e_form_error('address', $errors) !!}
            </div>

            @if ($user->google_id != NULL)
                <div class="intro-y col-span-12 sm:col-span-6 mb-5">
                    <div class="mb-2">@lang('app.provider')</div>
                    <input type="text" class="input w-full border flex-1" value="Google" placeholder="@lang('app.provider')" readonly>
                </div>
            @endif

            <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                <button type="submit" class="button w-40 justify-center block bg-theme-1 text-white">@lang('app.edit')</button>
            </div>
    </form>

        </div>
    </div>
</div>



@endsection
