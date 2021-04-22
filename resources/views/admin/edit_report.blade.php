@extends('layouts.dashboard')


@section('page-css')
@endsection

@section('content')
    <div class="intro-y box sm:py-20 mt-5">
        <div class="px-5 sm:px-20">
            <div class="font-medium text-base">@lang('app.edit')</div>
                <div class="gap-4 mt-5">
                    <form method="post" action="">
                        @csrf
                        <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('report')? 'has-error':'' }}">
                            <div class="mb-2">@lang('app.report')</div>
                                <textarea name="report" class="input w-full border flex-1  {{e_form_invalid_class('report', $errors)}}" rows="5">{!! $report->report !!}</textarea>
                                {!! $errors->has('report')? '<p class="help-block">'.$errors->first('report').'</p>':'' !!}
                                <p class="text-info"> @lang('app.report_info_text')</p>
                        </div>
                        <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                            <button type="submit" class="button w-40 justify-center block bg-theme-1 text-white">@lang('app.edit')</button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
@endsection


@section('page-js')

@endsection
