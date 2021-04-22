@extends('layouts.dashboard')

@section('content')
    <div class="intro-y box sm:py-20 mt-5">
        <form method="post" action="">
            @csrf
        <div class="px-5 sm:px-20">
            <div class="font-medium text-base">@lang('app.add_monthly_report')</div>
            <div class="gap-4 mt-5">

            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('name')? 'has-error':'' }}">
                <div class="mb-2">@lang('app.name')</div>
                <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('name', $errors)}}" id="name" value="{{ $application->name }}" name="name" placeholder="@lang('app.name')" readonly>
                <p style="color: #ff0000">{!! e_form_error('name', $errors) !!}
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('nim')? 'has-error':'' }}">
                <div class="mb-2">@lang('app.nim')</div>
                <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('nim', $errors)}}" id="nim" value="{{ $application->nim }}" name="nim" placeholder="@lang('app.nim')" readonly>
                <p style="color: #ff0000">{!! e_form_error('nim', $errors) !!}
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('email')? 'has-error':'' }}">
                <div class="mb-2">@lang('app.email')</div>
                <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('email', $errors)}}" id="email" value="{{ $application->email }}" name="email" placeholder="@lang('app.email')" readonly>
                <p style="color: #ff0000">{!! e_form_error('email', $errors) !!}
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('job')? 'has-error':'' }}">
                <div class="mb-2">@lang('app.job')</div>
                <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('job', $errors)}}" id="job" value="{{ $job->job_title }}" name="job" placeholder="@lang('app.job')" readonly>
                <p style="color: #ff0000">{!! e_form_error('job', $errors) !!}
            </div>

            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('report')? 'has-error':'' }}">
                <div class="mb-2">@lang('app.report')<font color="red">*</font></div>
                    <textarea name="report" class="input w-full border flex-1  {{e_form_invalid_class('report', $errors)}}" rows="5" required>{{ old('report') }}</textarea>
                    {!! $errors->has('report')? '<p class="help-block">'.$errors->first('report').'</p>':'' !!}
                     <p class="text-info"> @lang('app.report_info_text')</p>
            </div>

            <input type="hidden" name="application_id" value="{{$application->id}}" />
            <input type="hidden" name="user_id" value="{{$application->user_id}}" />
            <input type="hidden" name="job_id" value="{{$application->job_id}}" />
            <input type="hidden" name="nim" value="{{$application->nim}}" />
            <input type="hidden" name="name" value="{{$application->name}}" />
            <input type="hidden" name="progdi" value="{{$application->progdi}}" />
            <input type="hidden" name="email" value="{{$application->email}}" />

                <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                    <button type="submit" class="button w-40 justify-center block bg-theme-1 text-white">@lang('app.add')</button>
                </div>
        </form>
    </div>
@endsection




@section('page-js')
@endsection