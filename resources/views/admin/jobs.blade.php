@extends('layouts.dashboard')


@section('content')
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">

        @if($jobs->count())
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th>@lang('app.no')</th>
                        <th>@lang('app.job_title')</th>
                        <th>@lang('app.status')</th>
                        <th>@lang('app.employer')</th>
                        <th>@lang('app.googlemeet')</th>
                        <th>#</th>
                    </tr>
                </thead>

                @foreach($jobs as $key => $job)
                <tbody>
                    <tr>
                        <td>
                            {{ $jobs->firstItem() + $key }}
                        </td>
                        <td>
                            {{$job->job_title}}
                            <p class="text-muted">@lang('app.deadline') {{$job->deadline->format(get_option('date_format'))}} </p>
                            <p class="text-muted"> <a style="color: #1c3faa" href="{{route('job_applicants', $job->id)}}">@lang('app.applicant') ({{$job->application->count()}}) </a>  </p>
                        </td>
                        <td>
                            @if ($job->status == 0)
                                <div class="rounded-md flex items-center px-3 py-3 mb-1 bg-theme-12 text-white">
                                    <i class="fal fa-hourglass-half w-5 h-5 mr-1"></i>
                                    {!! $job->status_context() !!}
                                </div>   
                            @elseif($job->status == 1)
                                <div class="rounded-md flex items-center px-3 py-3 mb-1 bg-theme-14 text-theme-10">
                                    <i class="fal fa-check w-5 h-5 mr-1"></i>
                                    {!! $job->status_context() !!}
                                </div>   
                            @else
                                <div class="rounded-md flex items-center px-3 py-3 mb-1 bg-theme-6 text-white">
                                    <i class="fal fa-times w-5 h-5 mr-1"></i>
                                    {!! $job->status_context() !!}
                                </div>   
                            @endif
     
                            @if($job->is_premium)
                            <div class="rounded-md flex items-center px-3 py-3 mb-1 bg-theme-14 text-theme-10">
                                <i class="fal fa-crown w-5 h-5 mr-1"></i>
                                @lang('app.premium')
                            </div>
                            @endif
                        </td>
                        <td>
                            {{$job->employer->company}}
                        </td>
                        <td>
                            @if(!$job->googlemeet_room == NULL)
                                <button class="tooltip button px-2 mr-1 mb-2 bg-theme-42 text-white" title="@lang("app.googlemeet")">
                                    <a href="{{$job->googlemeet_room}}" target="_blank">
                                    <span class="w-5 h-5 flex items-center justify-center">
                                        <i class="fal fa-video w-4 h-4"></i>
                                    </span>
                                    </a>
                                </button>
                                {{-- <a href="{{$job->googlemeet_room}}" target="_blank">{{$job->googlemeet_room}}</a> --}}
                            @else
                                <p> - </p>
                            @endif
                        </td>
                        <td>
                            <button class="tooltip button px-2 mr-1 mb-2 bg-theme-1 text-white" title="@lang("app.view")">
                                <a href="{{route('job_view', $job->job_slug)}}" target="_blank">
                                <span class="w-5 h-5 flex items-center justify-center">
                                    <i class="fal fa-eye w-4 h-4"></i>
                                </span>
                                </a>
                            </button>

                             <button class="tooltip button px-2 mr-1 mb-2 border text-gray-700" title="@lang("app.edit")">
                                <a href="{{route('edit_job', $job->id)}}">
                                <span class="w-5 h-5 flex items-center justify-center">
                                    <i class="fal fa-edit w-4 h-4"></i>
                                </span>
                                </a>
                            </button>

                            @if(!$job->is_premium)
                                <button class="tooltip button px-2 mr-1 mb-2 bg-theme-9 text-white" title="@lang("app.mark_premium")">
                                    <a href="{{route('job_status_change', [$job->id, 'premium'])}}">
                                    <span class="w-5 h-5 flex items-center justify-center">
                                        <i class="fal fa-bookmark w-4 h-4"></i>
                                    </span>
                                    </a>
                                </button>
                            @endif

                            @if(auth()->user()->is_admin())
                                @if($job->is_premium)
                                    <button class="tooltip button px-2 mr-1 mb-2 bg-theme-6 text-white"  title="@lang("app.unmark_premium")">
                                        <a href="{{route('job_status_change', [$job->id, 'unpremium'])}}">
                                        <span class="w-5 h-5 flex items-center justify-center">
                                            <i class="fal fa-bookmark w-4 h-4"></i>
                                        </span>
                                        </a>
                                    </button>
                                @endif

                                @if($job->status != 1)
                                    <button class="tooltip button px-2 mr-1 mb-2 bg-theme-9 text-white" title="@lang("app.approved")">
                                        <a href="{{route('job_status_change', [$job->id, 'approve'])}}">
                                        <span class="w-5 h-5 flex items-center justify-center">
                                            <i class="fal fa-check-circle w-4 h-4"></i>
                                        </span>
                                        </a>
                                    </button>
                                @endif

                                @if($job->status != 2)
                                    <button class="tooltip button px-2 mr-1 mb-2 bg-theme-12 text-white" title="@lang("app.blocked")">
                                        <a href="{{route('job_status_change', [$job->id, 'block'])}}">
                                        <span class="w-5 h-5 flex items-center justify-center">
                                            <i class="fal fa-ban w-4 h-4"></i>
                                        </span>
                                        </a>
                                    </button>
                                @endif

                                <button class="tooltip button px-2 mr-1 mb-2 bg-theme-6 text-white" title="@lang("app.delete")">
                                    <a href="{{route('job_status_change', [$job->id, 'delete'])}}">
                                    <span class="w-5 h-5 flex items-center justify-center">
                                        <i class="fal fa-trash-alt w-4 h-4"></i>
                                    </span>
                                    </a>
                                </button>
                            @endif

                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
            {!! $jobs->links('vendor.pagination.tailwind') !!}
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
