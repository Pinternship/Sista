@extends('layouts.dashboard')

@section('content')
<div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th>@lang('app.job_title')</th>
                <th>@lang('app.reason')
                <th>@lang('app.message')</th>
                <th>@lang('app.job_action')</th>                
            </tr>
        </thead>
        @foreach($flagged as $flag)
        <tbody>
            <tr>
                <td>
                    <a href="{{route('job_view', $flag->job->job_slug)}}" target="_blank"><font color="#1488f0">{{$flag->job->job_title}}</font></a>
                    <p class="text-muted">{{$flag->email}}</p>
                    <p class="text-muted">
                        {{$flag->created_at->format(get_option('date_format'))}} {{$flag->created_at->format(get_option('time_format'))}}
                    </p>
                </td>
                <td>
                    @php
                    $locale_problem = 'app.'.$flag->reason;
                    @endphp
                    @lang($locale_problem)
                </td>
                <td> {!! nl2br($flag->message) !!} </td>
                <td>
                    <button class="tooltip button px-2 mr-1 mb-2 bg-theme-1 text-white" title="@lang("app.view")">
                        <a href="{{route('job_view', $flag->job->job_slug)}}" target="_blank">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="fal fa-eye w-4 h-4"></i>
                        </span>
                        </a>
                    </button>

                     <button class="tooltip button px-2 mr-1 mb-2 border text-gray-700" title="@lang("app.edit")">
                        <a href="{{route('edit_job', $flag->job->id)}}">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="fal fa-edit w-4 h-4"></i>
                        </span>
                        </a>
                    </button>

                    @if($flag->job->status != 1)
                        <button class="tooltip button px-2 mr-1 mb-2 bg-theme-9 text-white" title="@lang("app.approved")">
                            <a href="{{route('job_status_change', [$flag->job->id, 'approve'])}}">
                            <span class="w-5 h-5 flex items-center justify-center">
                                <i class="fal fa-check-circle w-4 h-4"></i>
                            </span>
                            </a>
                        </button>
                    @endif


                    @if($flag->job->status != 2)
                        <button class="tooltip button px-2 mr-1 mb-2 bg-theme-12 text-white" title="@lang("app.blocked")">
                            <a href="{{route('job_status_change', [$flag->job->id, 'block'])}}">
                            <span class="w-5 h-5 flex items-center justify-center">
                                <i class="fal fa-ban w-4 h-4"></i>
                            </span>
                            </a>
                        </button>
                    @endif
                    <button class="tooltip button px-2 mr-1 mb-2 bg-theme-6 text-white" title="@lang("app.delete")">
                        <a href="{{route('job_status_change', [$flag->job->id, 'delete'])}}">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="fal fa-trash-alt w-4 h-4"></i>
                        </span>
                        </a>
                    </button>
                </td>
            </tr>
        </tbody>
        @endforeach
    </table>
    {!! $flagged->links('vendor.pagination.tailwind') !!}
</div>
@endsection