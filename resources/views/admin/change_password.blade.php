@extends('layouts.dashboard')


@section('content')
<div class="intro-y box sm:py-20 mt-5">
    <form method="post" action="">
        @csrf
        <div class="px-5 sm:px-20">
            <div class="font-medium text-base">@lang('app.new_password')</div>
            <div class="gap-4 mt-5">
                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('old_password')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.old_password') <font color="red">*</font></div>
                    <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('old_password', $errors)}}" id="old_password" value="{{ old('old_password') }}" name="old_password" placeholder="@lang('app.old_password')" required>
                    <p style="color: #ff0000">{!! e_form_error('old_password', $errors) !!}
                </div>
                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('new_password')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.new_password') <font color="red">*</font></div>
                    <input type="password" class="input w-full border flex-1 {{e_form_invalid_class('new_password', $errors)}}" id="new_password" value="{{ old('new_password') }}" name="new_password" placeholder="@lang('app.new_password')" required>
                    <p style="color: #ff0000">{!! e_form_error('new_password', $errors) !!}
                </div>
                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('new_password_confirmation')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.old_password_confirmation') <font color="red">*</font></div>
                    <input type="password" class="input w-full border flex-1 {{e_form_invalid_class('new_password_confirmation', $errors)}}" id="new_password_confirmation" value="{{ old('new_password_confirmation') }}" name="new_password_confirmation" placeholder="@lang('app.old_password_confirmation')" required>
                    <p style="color: #ff0000">{!! e_form_error('new_password_confirmation', $errors) !!}
                </div>

                <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                    <button type="submit" class="button w-40 justify-center block bg-theme-1 text-white">@lang('app.change_password')</button>
                </div>
            
            </div>
        </div>
    </form>
</div>



@endsection