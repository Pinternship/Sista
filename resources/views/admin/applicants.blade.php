@extends('layouts.dashboard')

@section('content')
    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">@lang('app.no')</th>
                    <th class="border-b-2 whitespace-no-wrap">@lang('app.apply_profile')</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">@lang('app.photo')</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">@lang('app.ipk')</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">@lang('app.apply_data')</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">@lang('app.employer')</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">@lang('app.status')</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">@lang('app.action')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $key => $application)
                <tr>
                    <td>
                        {{ $applications->firstItem() + $key }}
                    </td>
                    <td class="border-b">
                        <div class="font-medium whitespace-no-wrap">{{$application->name}}</div>
                        <div class="text-gray-600 text-xs whitespace-no-wrap">@lang('app.nim') : {{$application->nim}}</div>
                        <div class="text-gray-600 text-xs whitespace-no-wrap">@lang('app.progdi') : {{$application->progdi}}</div>
                        <div class="text-gray-600 text-xs whitespace-no-wrap"><i class="far fa-at"> {{$application->email}}</i></div>
                        <div class="text-gray-600 text-xs whitespace-no-wrap"><i class="far fa-phone"> {{$application->phone_number}}</i></div>
                        <div class="text-gray-600 text-xs whitespace-no-wrap"><i class="far fa-clock"> {{$application->created_at->format(get_option('date_format'))}} {{$application->created_at->format(get_option('time_format'))}}</i></div>
                    </td>
                    <td class="text-center">
                        <div class="flex sm:justify-center">
                             <div class="relative">
                                <img alt="{{$application->name}}" src="{{$application->photo_url}}" data-action="zoom" style="max-width: 100px;">
                            </div>
                        </div>
                    </td>
                    <td class="text-center border-b">{{$application->ipk}}</td>
                    <td class="w-40 border-b">
                        <form action="{{ route('transkrip_pdf') }}" method="POST" target="_blank">
                            @csrf
                                <input name="nim" type="hidden" value="{{$application->nim}}" required>
                                <button type="submit" class="button px-2 mr-1 mb-2 bg-theme-9 text-white">@lang('app.transkrip')</button>
                        </form>

                        <form action="{{ route('transkrip_skpi') }}" method="POST" target="_blank">
                            @csrf
                                <input name="nim" type="hidden" value="{{$application->nim}}" required>
                                <button type="submit" class="button px-2 mr-1 mb-2 bg-theme-9 text-white">@lang('app.skpi')</button>
                        </form>

                        <button class="button px-2 mr-1 mb-2 bg-theme-9 text-white">
                            <a href="{{$application->resume_url}}" target="_blank">
                                @lang('app.resume')
                            </a>
                        </button>
                    </td>
                    <td class="border-b w-5">
                        @if( ! empty($application->job->job_title))
                            <p>
                                <a href="{{route('job_view', $application->job->job_slug)}}" target="_blank"><font color="#1488f0">{{$application->job->job_title}}</font></a>
                            </p>
                        @endif

                        @if( ! empty($application->job->employer->company))
                            <p>{{$application->job->employer->company}}</p>
                        @endif
                    </td>
                    <td class="border-b w-5">
                        @if ($application->user_status == '0')
                            @lang('app.pending')
                        @elseif ($application->user_status == '1')
                            @lang('app.approved')
                        @else
                            @lang('app.error')
                        @endif
                    </td>
                    <td>
                        @if($application->is_shortlisted == '0' && $application->status == '0')
                            <button class="button px-2 mr-1 mb-2 bg-theme-9 text-white">
                                <a href="{{route('make_short_list', $application->id)}}">
                                    @lang('app.shortlist')
                                </a>
                            </button>
                        @elseif($application->is_shortlisted == '1' && $application->status == '0')
                            <button class="button px-2 mr-1 mb-2 bg-theme-12 text-white">
                                    <a href="{{route('remove_short_list', $application->id)}}">
                                        @lang('app.remove_shortlist')
                                    </a>
                            </button>
                        @endif

                        @if($application->status == '0' && $application->is_shortlisted == '1')
                            <button class="button px-2 mr-1 mb-2 bg-theme-9 text-white">
                                    <a href="{{route('make_accept_list', $application->id)}}">
                                         @lang('app.accept')
                                    </a>
                            </button>
                        @elseif ($application->status == '1' && $application->is_shortlisted == '1')
                            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal-preview" class="button inline-block bg-theme-12 text-white">@lang('app.remove')</a>

                            <div class="modal" id="delete-modal-preview">
                                <div class="modal__content">
                                    <div class="p-5 text-center">
                                        <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                                        <div class="text-3xl mt-5">Are you sure?</div>
                                        <div class="text-gray-600 mt-2">@lang('app.unaccept_notification_1') {{$application->name}} @lang('app.unaccept_notification_2')</div>
                                    </div>

                                    <form action="{{route('remove_accept_list', $application->id)}}" method="get" id="applyJob" enctype="multipart/form-data">
                                        @csrf
                                        <div class="px-5 pb-8 text-center">
                                            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Cancel</button>
                                            <button type="submit" class="button w-24 bg-theme-6 text-white">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div> 
                            <p>
                                @lang('app.accept_notification')
                            </p>
                        @endif                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('page-js')

@endsection

@section('scripts')

<script type="text/javascript">

</script>

@endsection