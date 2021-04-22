@extends('layouts.dashboard')

@section('content')
<div class="intro-y box sm:py-20 mt-5">
    <form method="post" action="" enctype="multipart/form-data">
        @csrf

        @php
        $package1 = \App\Models\Pricing::find(1);
        $package1 = $package1 ? $package1->toArray() : $package1;

        $package2 = \App\Models\Pricing::find(2);
        $package2 = $package2 ? $package2->toArray() : $package2;
        @endphp

        <div class="px-5 sm:px-20">
            <div class="font-medium text-base">@lang('app.pricing_settings')</div>
            <div class="gap-4 mt-5">

                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('package_name')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.package_name') <font color="red">*</font></div>
                    <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('package_name', $errors)}}" id="package_name" value="{{array_get($package1, 'package_name')}}" name="package[1][package_name]" placeholder="@lang('app.package_name')" required>
                    <p style="color: #ff0000">{!! e_form_error('package_name', $errors) !!}
                </div>

                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('price')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.price') <font color="red">*</font></div>
                    <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('price', $errors)}}" id="price" value="{{array_get($package1, 'price')}}" name="package[1][price]" placeholder="@lang('app.price')" required>
                    <p style="color: #ff0000">{!! e_form_error('price', $errors) !!}
                </div>

                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('premium_job')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.premium_job') <font color="red">*</font></div>
                    <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('premium_job', $errors)}}" id="premium_job" value="{{array_get($package1, 'premium_job')}}" name="package[1][premium_job]" placeholder="@lang('app.premium_job')" required>
                    <p style="color: #ff0000">{!! e_form_error('premium_job', $errors) !!}
                </div>

                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('package_name')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.package_name') <font color="red">*</font></div>
                    <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('package_name', $errors)}}" id="package_name" value="{{array_get($package2, 'package_name')}}" name="package[2][package_name]" placeholder="@lang('app.package_name')" required>
                    <p style="color: #ff0000">{!! e_form_error('package_name', $errors) !!}
                </div>

                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('price')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.price') <font color="red">*</font></div>
                    <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('price', $errors)}}" id="price" value="{{array_get($package2, 'price')}}" name="package[2][price]" placeholder="@lang('app.price')" required>
                    <p style="color: #ff0000">{!! e_form_error('price', $errors) !!}
                </div>

                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('premium_job')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.premium_job') <font color="red">*</font></div>
                    <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('premium_job', $errors)}}" id="premium_job" value="{{array_get($package2, 'premium_job')}}" name="package[2][premium_job]" placeholder="@lang('app.premium_job')" required>
                    <p style="color: #ff0000">{!! e_form_error('premium_job', $errors) !!}
                </div>

                <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                    <button type="submit" class="button w-40 justify-center block bg-theme-1 text-white">@lang('app.save_package')</button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection