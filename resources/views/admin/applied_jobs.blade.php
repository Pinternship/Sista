@extends('layouts.dashboard')

@section('content')
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        @if($applications->count())
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th>@lang('app.no')</th>
                        <th>@lang('app.photo')</th>
                        <th>@lang('app.profile')</th>
                        <th>@lang('app.ipk')</th>
                        <th>@lang('app.apply_data')</th>
                        <th>@lang('app.employer')</th>
                        <th>@lang('app.status')</th>
                    </tr>
                </thead>

            @foreach($applications as $key => $application)
                <tbody>
                    <tr>
                        <td>
                            {{ $applications->firstItem() + $key }}
                        </td>
                        <td>
                            <div class="flex sm:justify-center">
                                 <div class="relative">
                                    <img alt="{{$application->name}}" src="{{$application->photo_url}}" data-action="zoom" style="max-width: 100px;">
                                </div>
                            </div>
                        </td>
                        <td>
                            <p>@lang('app.name') : {{$application->name}}</p>
                            <p>@lang('app.nim') : {{$application->nim}}</p>
                            <p>@lang('app.progdi') : {{$application->progdi}}</p>
                            <p><i class="la la-envelope-o"></i> {{$application->email}}</p>
                            <p><i class="la la-phone-square"></i> {{$application->phone_number}}</p>
                            <p class="text-muted"><i class="la la-clock-o"></i> {{$application->created_at->format(get_option('date_format'))}} {{$application->created_at->format(get_option('time_format'))}}</p>
                        </td>
                        <td>
                            {{$application->ipk}}
                        </td>
                        <td>
                            {{-- <p>
                                <a href="{{$application->transkrip}}" target="_blank" class="btn btn-success"><i class="la la-clipboard"></i> @lang('app.transkrip') </a>
                            </p>
                            <p>
                                <a href="{{$application->skpi}}" target="_blank" class="btn btn-success"><i class="la la-file-text"></i> @lang('app.skpi') </a>
                            </p> --}}
                            <p>
                                <a href="{{$application->resume_url}}" target="_blank" class="button butn__new w-32 mr-2 mb-2 flex items-center justify-center bg-theme-9 text-white"> <i data-feather="clipboard" class="w-4 h-4 mr-2"></i> @lang('app.resume') </a> 
                            </p>
                        </td>

                        <td>
                            @if( ! empty($application->job->job_title))
                                <p>
                                    <a href="{{route('job_view', $application->job->job_slug)}}" target="_blank"><font color="#1488f0">{{$application->job->job_title}}</font></a>
                                </p>
                            @endif

                            @if( ! empty($application->job->employer->company))
                                <p>{{$application->job->employer->company}}</p>
                            @endif
                        </td>
                        <td>
                            @if($application->is_shortlisted == 1 && $application->status == 1)
                                @if($application->user_status == 0)
                                    <button class="button px-2 mr-1 mb-2 bg-theme-9 text-white">
                                        <a href="{{route('make_accept', $application->id)}}">
                                            @lang('app.accept')
                                        </a>
                                    </button> 
                                @else
                                    @lang('app.approved')
                                @endif
                            @else
                                @lang('app.waiting_for_approval')                             
                            @endif
                        </td>
                    </tr>
                </tbody>
            @endforeach
            </table>

            <!-- BEGIN: Pagination -->

            <!-- END: Pagination -->
            {!! $applications->links('vendor.pagination.tailwind') !!}

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