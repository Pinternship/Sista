@extends('layouts.dashboard')


@section('page-css')
@endsection

@section('content')
    <div class="intro-y box sm:py-20 mt-5">
        <div class="px-5 sm:px-20">
            <div class="font-medium text-base">@lang('app.add_final_report')</div>
                <div class="gap-4 mt-5">
                <form method="post" action="">
                    @csrf
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
                        <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('job_duration')? 'has-error':'' }}">
                            <div class="mb-2">@lang('app.job_duration')</div>
                            <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('job', $errors)}}" id="job_duration" value="{{ $job->job_duration }}" name="job_duration" placeholder="@lang('app.job_duration')" readonly>
                            <p style="color: #ff0000">{!! e_form_error('job_duration', $errors) !!}
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('report_perusahaan_bulanan')? 'has-error':'' }}">
                            <div class="mb-2">@lang('app.report_perusahaan_bulanan')</div>
                            <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('job', $errors)}}" id="report_perusahaan_bulanan" value="{{ $report->count() }}" name="report_perusahaan_bulanan" placeholder="@lang('app.report_perusahaan_bulanan')" readonly>
                            <p style="color: #ff0000">{!! e_form_error('report_perusahaan_bulanan', $errors) !!}</p>
                        </div>

                        @if($report->count() == $job->job_duration)
                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('report')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.report')<font color="red">*</font></div>
                                    <textarea name="report" class="input w-full border flex-1  {{e_form_invalid_class('report', $errors)}}" rows="5" required>{{ old('report') }}</textarea>
                                    {!! $errors->has('report')? '<p class="help-block">'.$errors->first('report').'</p>':'' !!}
                                     <p class="text-info"> @lang('app.report_info_text')</p>
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('nilai')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.score')<font color="red">*</font></div>
                                    <textarea name="nilai" class="input w-full border flex-1  {{e_form_invalid_class('nilai', $errors)}}" rows="5" required>{{ old('nilai') }}</textarea>
                                    {!! $errors->has('nilai')? '<p class="help-block">'.$errors->first('nilai').'</p>':'' !!}
                                     <p class="text-info"> @lang('app.score_info_text')</p>
                            </div>
                        @else
                            <div class="form-group row">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-8">
                                    <h3>To complete the final report, it's required that the number of monthly reports is same as duration of the internship</h3>
                                </div>
                            </div>
                        @endif

                        <input type="hidden" name="application_id" value="{{$application->id}}" />
                        <input type="hidden" name="user_id" value="{{$application->user_id}}" />
                        <input type="hidden" name="job_id" value="{{$application->job_id}}" />
                        <input type="hidden" name="nim" value="{{$application->nim}}" />
                        <input type="hidden" name="name" value="{{$application->name}}" />
                        <input type="hidden" name="progdi" value="{{$application->progdi}}" />
                        <input type="hidden" name="email" value="{{$application->email}}" />

                        @if($report->count() == $job->job_duration)
                            <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                                <button type="submit" class="button w-40 justify-center block bg-theme-1 text-white">@lang('app.add')</button>
                            </div>
                        @else
                        <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                            <a href="{{route('report_final')}}" class="button w-40 justify-center block bg-theme-1 text-white"></i>@lang('app.back')</a>
                        </div>
                        @endif
                </form>
            </div>
        </div>
    </div>
@endsection




@section('page-js')
    <script src="{{asset('assets/plugins/bootstrap-datepicker-1.6.4/js/bootstrap-datepicker.js')}}" defer></script>
@endsection
