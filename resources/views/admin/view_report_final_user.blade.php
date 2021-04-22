@extends('layouts.dashboard')

@section('content')
<div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
    @if($reports->count())
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th>@lang('app.no')</th>
                <th>@lang('app.apply_profile')</th>
                <th>@lang('app.employer')</th>
                <th>@lang('app.action')</th>
            </tr>
        </thead>    
        @foreach($reports as $key => $report)
            <tbody>
                <tr>
                    <td>
                        {{ $reports->firstItem() + $key }}
                    </td>
                    <td>
                        <p>@lang('app.name') : {{$report->name}}</p>
                        <p>@lang('app.nim') : {{$report->nim}}</p>
                        <p>@lang('app.progdi') : {{$report->progdi}}</p>
                    </td>
                    <td>
                        @if( ! empty($report->job->job_title))
                            <p>
                                <a href="{{route('job_view', $report->job->job_slug)}}" target="_blank"><font color="#1488f0">{{$report->job->job_title}}</font></a>
                            </p>
                        @endif

                        @if( ! empty($report->job->employer->company))
                            <p>{{$report->job->employer->company}}</p>
                        @endif
                    </td>
                    <td>
                        <button class="tooltip button px-2 mr-1 mb-2 bg-theme-4 text-white" title="@lang('app.pdf')">
                            <a href="{{route('report_final_pdf_user', $report->id)}}" target="_blank">
                            <span class="w-5 h-5 flex items-center justify-center">
                                <i class="fal fa-file-pdf w-4 h-4"></i>
                            </span>
                            </a>
                        </button>
                    </td>
                </tr>
            </tbody>
        @endforeach
        </table>

        {!! $reports->links('vendor.pagination.tailwind') !!}
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

</div>



@endsection
