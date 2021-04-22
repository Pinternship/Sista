@extends('layouts.dashboard')

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        {{$title}}
    </h2>
</div>

<!-- BEGIN: Datatable -->
@if($applications->count() > 0)
<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full">
        <thead>
            <tr>
                <th class="border-b-2 whitespace-no-wrap">@lang('app.photo')</th>
                <th class="border-b-2 whitespace-no-wrap">@lang('app.apply_profile')</th>
                <th class="border-b-2 whitespace-no-wrap">@lang('app.employer')</th>
                <th class="border-b-2 whitespace-no-wrap">@lang('app.action')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $application)
            <tr>
                <td class="border-b">
                    <div class="flex sm:justify-center">
                         <div class="relative">
                            <img alt="{{$application->name}}" src="{{$application->photo_url}}" data-action="zoom" style="max-width: 100px;">
                        </div>
                    </div>
                </td>
                <td class="border-b">
                    <p>@lang('app.name') : {{$application->name}}</p>
                    <p>@lang('app.nim') : {{$application->nim}}</p>
                    <p>@lang('app.progdi') : {{$application->progdi}}</p>
                </td>
                <td class="border-b">
                    @if( ! empty($application->job->job_title))
                        <p>
                            <a href="{{route('job_view', $application->job->job_slug)}}" target="_blank"><font color="#1488f0">{{$application->job->job_title}}</font></a>
                        </p>
                    @endif

                    @if( ! empty($application->job->employer->company))
                        <p>{{$application->job->employer->company}}</p>
                    @endif
                </td>
                <td class="border-b">
                    @if(!auth()->user()->is_faculty())
                        <button class="tooltip button px-2 mr-1 mb-2 bg-theme-9 text-white" title="@lang('app.add')">
                            <a href="{{route('report_final_add', $application->id)}}" target="_blank">
                            <span class="w-5 h-5 flex items-center justify-center">
                                <i class="fal fa-plus w-4 h-4"></i>
                            </span>
                            </a>
                        </button>
                    
                        <button class="tooltip button px-2 mr-1 mb-2 bg-theme-3 text-white" title="@lang('app.view_report')">
                            <a href="{{route('report_final_view', $application->id)}}" target="_blank">
                            <span class="w-5 h-5 flex items-center justify-center">
                                <i class="fal fa-eye w-4 h-4"></i>
                            </span>
                            </a>
                        </button>
                    @else
                        <button class="tooltip button px-2 mr-1 mb-2 bg-theme-3 text-white" title="@lang('app.view_report')">
                            <a href="{{route('report_final_view_faculty', $application->id)}}" target="_blank">
                            <span class="w-5 h-5 flex items-center justify-center">
                                <i class="fal fa-eye w-4 h-4"></i>
                            </span>
                            </a>
                        </button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
    <div class="row">
        <div class="col-md-12">
            <div class="no data-wrap py-5 my-5 text-center">
                <h1 class="display-1"><i class="la la-frown-o"></i> </h1>
                <h1>No Data available here</h1>
            </div>
        </div>
    </div>
@endif
<!-- END: Datatable -->
@endsection

@section('page-js')

@endsection

@section('scripts')

<script type="text/javascript">

</script>

@endsection