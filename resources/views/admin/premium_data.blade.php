@extends('layouts.dashboard')


@section('content')
    <!-- BEGIN: No data -->
    @if(auth()->user()->is_employer() && auth()->user()->created_by == "1")
        <!-- BEGIN: Profile Info -->
        <div class="intro-y box px-5 pt-5 mt-5">
            <div class="flex flex-col lg:flex-row border-b border-gray-200 pb-5 -mx-5">
                <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                        <img alt="Midone Tailwind HTML Admin Template" class="rounded-full" src="{{$user->logo_url}}">
                    </div>
                    <div class="ml-5">
                        <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{$user->name}}</div>
                        <div class="text-gray-600">{{$user->company}}</div>
                    </div>
                </div>

                <div class="flex mt-6 lg:mt-0 items-center lg:items-start flex-1 flex-col justify-center text-gray-600 px-5 border-l border-r border-gray-200 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="mail" class="w-4 h-4 mr-2"></i> {{$user->email}} </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="link" class="w-4 h-4 mr-2"></i> <a href="{{$user->website}}"> {{$user->website}} </a></div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="phone" class="w-4 h-4 mr-2"></i>{{$user->phone}}</a></div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="map-pin" class="w-4 h-4 mr-2"></i> {{$user->address}} -  {{$user->address2}} - {{$user->city}}</div>
                </div>
            </div>
            <div class="nav-tabs flex flex-col sm:flex-row justify-center lg:justify-start">
                <a data-toggle="tab" data-target="{{route('dashboard')}}" href="{{route('dashboard')}}" class="py-4 sm:mr-8">Dashboard</a>
                <a data-toggle="tab" data-target="{{route('dashboard_premium_data')}}" href="{{route('dashboard_premium_data')}}" class="py-4 sm:mr-8 active">Premium Data</a>
                <a data-toggle="tab" data-target="{{route('profile')}}" href="{{route('profile')}}" class="py-4 sm:mr-8">Account & Profile</a>
                <a data-toggle="tab" data-target="{{route('employer_profile')}}" href="{{route('employer_profile')}}" class="py-4 sm:mr-8">Edit Profile</a>
            </div>
        </div>
        <!-- END: Profile Info -->

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Dashboard
                        </h2>
                        <a href="{{route('dashboard')}}" class="ml-auto flex text-theme-1"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                    </div>

                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <div style="font-size: 24px;">
                                            <i class="report-box__icon text-theme-10 fal fa-books fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$totalJobs}}</div>
                                    <div class="text-base text-gray-600 mt-1">Total Jobs</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <div style="font-size: 24px;">
                                            <i class="report-box__icon text-theme-10 fal fa-book fa-lg"></i>
                                        </div>
                                        <div class="ml-auto">
                                            @php
                                                try {
                                                    $persenjob = $activeJobs/$totalJobs*100;
                                                } catch (Exception $e) {
                                                    $persenjob = 0;
                                                }
                                            @endphp
                                            <div class="report-box__indicator bg-theme$( document ).ready(function() {-9 tooltip cursor-pointer" title="{{$persenjob}}% From total jobs"> {{round($persenjob)}}% </div>
                                        </div>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$activeJobs}}</div>
                                    <div class="text-base text-gray-600 mt-1">Active Jobs</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <div style="font-size: 24px;">
                                            <i class="report-box__icon text-theme-10 fal fa-eye fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$totalJobview}}</div>
                                    <div class="text-base text-gray-600 mt-1">Jobs View</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <div style="font-size: 24px;">
                                            <i class="report-box__icon text-theme-10 fal fa-address-card fa-lg"></i>
                                        </div>
                                        <div class="ml-auto">
                                            @php
                                            try {
                                                $persenapplied = $totalApplicants/$totalJobview*100;
                                            } catch (Exception $e) {
                                                $persenapplied = 0;
                                            }
                                            @endphp
                                            <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="{{round($persenapplied)}}% From total jobs view"> {{round($persenapplied)}}% </div>
                                        </div>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$totalApplicants}}</div>
                                    <div class="text-base text-gray-600 mt-1">Total Applied</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: General Report -->
            </div>

            <!-- BEGIN: Top Companies -->
            <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        @lang('app.top_companie_by_jobs')
                    </h2>
                </div>
                <div class="intro-y box p-5 mt-5">
                    <canvas class="mt-3" id="jobs" height="280"></canvas>
                    <div class="mt-8">
                        @foreach($company_tops_jobs as $company_tops_job)
                        <div class="flex items-center mt-4">
                                <span data-tooltip-content="#custom-content-tooltip" class="tooltip inline-block">
                                    <span class="truncate">{{ batas_job($company_tops_job->employer->company) }}</span>
                                </span>
                                <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden"></div>
                                <span class="font-medium xl:ml-auto">{{ $company_tops_job->jumlah }} Job</span> 
                                 <div class="tooltip-content">
                                     <div id="custom-content-tooltip" class="relative flex items-center py-1">
                                         <div class="w-12 h-12 image-fit"> <img alt="" class="rounded-full" src="{{ $company_tops_job->employer->logo_url }}"> </div>
                                         <div class="ml-4 mr-auto">
                                             <div class="font-medium dark:text-gray-300 leading-relaxed">{{ $company_tops_job->employer->company }}</div>
                                         </div>
                                     </div>
                                 </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        @lang('app.top_companie_by_view')
                    </h2>
                </div>
                <div class="intro-y box p-5 mt-5">
                    <canvas class="mt-3" id="views" height="280"></canvas>
                    <div class="mt-8">
                        @foreach($company_tops_views as $company_tops_view)
                        <div class="flex items-center mt-4">
                                <span data-tooltip-content="#custom-content-tooltip" class="tooltip inline-block">
                                    <span class="truncate">{{ batas_job($company_tops_view->employer->company) }}</span>
                                </span>
                                <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden"></div>
                                <span class="font-medium xl:ml-auto">{{ $company_tops_view->jumlah }} View</span> 
                                 <div class="tooltip-content">
                                     <div id="custom-content-tooltip" class="relative flex items-center py-1">
                                         <div class="w-12 h-12 image-fit"> <img alt="" class="rounded-full" src="{{ $company_tops_view->employer->logo_url }}"> </div>
                                         <div class="ml-4 mr-auto">
                                             <div class="font-medium dark:text-gray-300 leading-relaxed">{{ $company_tops_view->employer->company }}</div>
                                         </div>
                                     </div>
                                 </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        @lang('app.top_companie_by_applyed')
                    </h2>
                </div>
                <div class="intro-y box p-5 mt-5">
                    <canvas class="mt-3" id="applyed" height="280"></canvas>
                    <div class="mt-8">
                        @foreach($company_tops_applyeds as $company_tops_applyed)
                        <div class="flex items-center mt-4">
                                <span data-tooltip-content="#custom-content-tooltip" class="tooltip inline-block">
                                    <span class="truncate">{{ batas_job($company_tops_applyed->employer->company) }}</span>
                                </span>
                                <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden"></div>
                                <span class="font-medium xl:ml-auto">{{ $company_tops_applyed->jumlah }} Applyed</span> 
                                 <div class="tooltip-content">
                                     <div id="custom-content-tooltip" class="relative flex items-center py-1">
                                         <div class="w-12 h-12 image-fit"> <img alt="" class="rounded-full" src="{{ $company_tops_applyed->employer->logo_url }}"> </div>
                                         <div class="ml-4 mr-auto">
                                             <div class="font-medium dark:text-gray-300 leading-relaxed">{{ $company_tops_applyed->employer->company }}</div>
                                         </div>
                                     </div>
                                 </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        @lang('app.active_jobs')
                    </h2>
                </div>
                <div class="intro-y box p-5 mt-5">
                    <div class="mt-8">
                        @foreach($regular_jobs as $regular_job)
                        <div class="flex items-center mt-4">
                            <div class="w-2 h-2 bg-theme-11 rounded-full mr-3"></div>
                                <a href="{{route('job_view', $regular_job->job_slug)}}"  data-tooltip-content="#custom-content-tooltip" class="tooltip inline-block">
                                    <span class="truncate">{{ $regular_job->job_title }}</span>
                                </a>
                                 <div class="tooltip-content">
                                     <div id="custom-content-tooltip" class="relative flex items-center py-1">
                                         <div class="w-12 h-12 image-fit"> <img alt="" class="rounded-full" src="{{ $regular_job->employer->logo_url }}"> </div>
                                         <div class="ml-4 mr-auto">
                                             <div class="font-medium dark:text-gray-300 leading-relaxed">{{ $regular_job->employer->company }}</div>
                                             <div class="text-gray-600">{{$regular_job->deadline->diffForHumans()}}</div>
                                         </div>
                                     </div>
                                 </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- END: Top Companies -->

            <!-- BEGIN: Top Student List -->
            <div class="col-span-12 mt-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        @lang('app.top_student_list')
                    </h2>

                    <div class="dropdown xl:ml-auto mt-5 xl:mt-0">
                        <select class="input border w-60" id="progdi_top_student_list">
                            <option value="" selected="selected">Filter By Progdi</option>
                            @foreach($progdis as $progdi)
                                <option value="{{$progdi->code}}">{{$progdi->nama_progdi}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="dropdown xl:ml-auto mt-5 xl:mt-0">
                        <select class="input border w-60" id="class_top_student_list">
                            <option value="" selected="selected">Filter By Class</option>
                            @foreach($years as $year)
                                <option value="{{$year}}">{{$year}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="intro-y datatable-wrapper box p-5 mt-5">
                <!-- BEGIN: Datatable -->
                    <table class="table table-report table-report--bordered display datatable w-full" id="top_student_list">
                    <thead>
                        <tr>
                            <th>@lang('app.name')</th>
                            <th>@lang('app.nim')</th>
                            <th>@lang('app.ipk')</th>
                            <th>@lang('app.email')</th>
                        </tr>
                    </thead>
                    </table>
                <!-- END: Datatable -->
                </div>
            </div>
            <!-- END: Top Student List  -->

            <!-- BEGIN: Latest Graduate List -->
            <div class="col-span-12 mt-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        @lang('app.latest_graduate_list')
                    </h2>
                    <div class="dropdown xl:ml-auto mt-5 xl:mt-0">
                        <select class="input border w-60" id="progdi_latest_graduate_list">
                            <option value="" selected="selected">Filter By Progdi</option>
                            @foreach($progdis as $progdi)
                                <option value="{{$progdi->code}}">{{$progdi->nama_progdi}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="intro-y datatable-wrapper box p-5 mt-5">
                <!-- BEGIN: Datatable -->
                    <table class="table table-report table-report--bordered display datatable w-full" id="latest_graduate_list">
                    <thead>
                        <tr>
                            <th>@lang('app.name')</th>
                            <th>@lang('app.nim')</th>
                            <th>@lang('app.ipk')</th>
                            <th>@lang('app.thesis_title')</th>
                            <th>@lang('app.graduate_date')</th>
                        </tr>
                    </thead>
                    </table>
                <!-- END: Datatable -->
                </div>
            </div>
            <!-- END: Latest Graduate List -->

            <!-- BEGIN: Flagged Job -->
            @if($flagjobs->count() > 0)
            <div class="col-span-12 xxl:col-span-3 xxl:border-l border-theme-5 -mb-10 pb-10">
                <div class="xxl:pl-6 grid grid-cols-12 gap-6">
                    <div class="col-span-12 md:col-span-6 xl:col-span-12 xxl:col-span-12 xl:col-start-1 xl:row-start-1 xxl:col-start-auto xxl:row-start-auto mt-3">
                        <div class="intro-x flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-auto">
                                @lang('app.flagged_jobs')
                            </h2>
                            <button data-carousel="important-notes" data-target="prev" class="tiny-slider-navigator button px-2 border border-gray-400 dark:border-dark-5 flex items-center text-gray-700 dark:text-gray-600 mr-2"> <i data-feather="chevron-left" class="w-4 h-4"></i> </button>
                            <button data-carousel="important-notes" data-target="next" class="tiny-slider-navigator button px-2 border border-gray-400 dark:border-dark-5 flex items-center text-gray-700 dark:text-gray-600"> <i data-feather="chevron-right" class="w-4 h-4"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- END: Flagged Job -->
        </div>


    @elseif(auth()->user()->is_faculty() && auth()->user()->created_by == "1")
        <!-- BEGIN: Profile Info -->
        <div class="intro-y box px-5 pt-5 mt-5">
            <div class="flex flex-col lg:flex-row border-b border-gray-200 pb-5 -mx-5">
                <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                        <img alt="Midone Tailwind HTML Admin Template" class="rounded-full" src="{{$user->logo_url}}">
                    </div>
                    <div class="ml-5">
                        <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{$user->name}}</div>
                        <div class="text-gray-600">{{$user->company}}</div>
                    </div>
                </div>
            </div>
            <div class="nav-tabs flex flex-col sm:flex-row justify-center lg:justify-start">
                <a data-toggle="tab" data-target="{{route('dashboard')}}" href="{{route('dashboard')}}" class="py-4 sm:mr-8">Dashboard</a>
                <a data-toggle="tab" data-target="{{route('dashboard_premium_data')}}" href="{{route('dashboard_premium_data')}}" class="py-4 sm:mr-8 active">Faculty Data</a>
                <a data-toggle="tab" data-target="{{route('profile')}}" href="{{route('profile')}}" class="py-4 sm:mr-8">Account & Profile</a>
                <a data-toggle="tab" data-target="{{route('employer_profile')}}" href="{{route('employer_profile')}}" class="py-4 sm:mr-8">Edit Profile</a>
            </div>
        </div>
        <!-- END: Profile Info -->

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Site Data
                        </h2>
                        <a href="{{route('dashboard')}}" class="ml-auto flex text-theme-1"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                    </div>

                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <div style="font-size: 24px;">
                                            <i class="report-box__icon text-theme-10 fal fa-books fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$totalJobs}}</div>
                                    <div class="text-base text-gray-600 mt-1">Total Jobs</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <div style="font-size: 24px;">
                                            <i class="report-box__icon text-theme-10 fal fa-book fa-lg"></i>
                                        </div>
                                        <div class="ml-auto">
                                            @php
                                                try {
                                                    $persenjob = $activeJobs/$totalJobs*100;
                                                } catch (Exception $e) {
                                                    $persenjob = 0;
                                                }
                                            @endphp
                                            <div class="report-box__indicator bg-theme$( document ).ready(function() {-9 tooltip cursor-pointer" title="{{$persenjob}}% From total jobs"> {{round($persenjob)}}% </div>
                                        </div>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$activeJobs}}</div>
                                    <div class="text-base text-gray-600 mt-1">Active Jobs</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <div style="font-size: 24px;">
                                            <i class="report-box__icon text-theme-10 fal fa-eye fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$totalJobview}}</div>
                                    <div class="text-base text-gray-600 mt-1">Jobs View</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <div style="font-size: 24px;">
                                            <i class="report-box__icon text-theme-10 fal fa-address-card fa-lg"></i>
                                        </div>
                                        <div class="ml-auto">
                                            @php
                                            try {
                                                $persenapplied = $totalApplicants/$totalJobview*100;
                                            } catch (Exception $e) {
                                                $persenapplied = 0;
                                            }
                                            @endphp
                                            <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="{{round($persenapplied)}}% From total jobs view"> {{round($persenapplied)}}% </div>
                                        </div>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$totalApplicants}}</div>
                                    <div class="text-base text-gray-600 mt-1">Total Applied</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: General Report -->
            </div>


            <!-- BEGIN: Score + Certificate Internship -->
            <div class="col-span-12 mt-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        @lang('app.score')
                    </h2>
                    <div class="dropdown xl:ml-auto mt-5 xl:mt-0">
                        <select class="input border w-60" id="progdi_certificate_faculty">
                            <option value="" selected="selected">Filter By Progdi</option>
                            @foreach($facultys as $faculty)
                                <option value="{{$faculty->code}}">{{$faculty->nama_progdi}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="intro-y datatable-wrapper box p-5 mt-5">
                <!-- BEGIN: Datatable -->
                    <table class="table table-report table-report--bordered display datatable w-full" id="certificate_faculty">
                    <thead>
                        <tr>
                            <th>@lang('app.no')</th>
                            <th>@lang('app.name')</th>
                            <th>@lang('app.nim')</th>
                            <th>@lang('app.progdi')</th>
                            <th>@lang('app.pdf')</th>
                        </tr>
                    </thead>
                    </table>
                <!-- END: Datatable -->
                </div>
            </div>
            <!-- END: Score + Certificate Internship -->

            <!-- BEGIN: Top Student List -->
            <div class="col-span-12 mt-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        @lang('app.top_student_list')
                    </h2>

                    <div class="dropdown xl:ml-auto mt-5 xl:mt-0">
                        <select class="input border w-60" id="progdi_top_student_list_faculty">
                            <option value="" selected="selected">Filter By Progdi</option>
                            @foreach($facultys as $faculty)
                                <option value="{{$faculty->code}}">{{$faculty->nama_progdi}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="dropdown xl:ml-auto mt-5 xl:mt-0">
                        <select class="input border w-60" id="class_top_student_list_faculty">
                            <option value="" selected="selected">Filter By Class</option>
                            @foreach($years as $year)
                                <option value="{{$year}}">{{$year}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="intro-y datatable-wrapper box p-5 mt-5">
                <!-- BEGIN: Datatable -->
                    <table class="table table-report table-report--bordered display datatable w-full" id="top_student_list_faculty">
                    <thead>
                        <tr>
                            <th>@lang('app.name')</th>
                            <th>@lang('app.nim')</th>
                            <th>@lang('app.ipk')</th>
                            <th>@lang('app.email')</th>
                        </tr>
                    </thead>
                    </table>
                <!-- END: Datatable -->
                </div>
            </div>
            <!-- END: Top Student List  -->

            <!-- BEGIN: Latest Graduate List -->
            <div class="col-span-12 mt-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        @lang('app.latest_graduate_list')
                    </h2>
                    <div class="dropdown xl:ml-auto mt-5 xl:mt-0">
                        <select class="input border w-60" id="progdi_latest_graduate_list_faculty">
                            <option value="" selected="selected">Filter By Progdi</option>
                            @foreach($facultys as $faculty)
                                <option value="{{$faculty->code}}">{{$faculty->nama_progdi}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="intro-y datatable-wrapper box p-5 mt-5">
                <!-- BEGIN: Datatable -->
                    <table class="table table-report table-report--bordered display datatable w-full" id="latest_graduate_list_faculty">
                    <thead>
                        <tr>
                            <th>@lang('app.name')</th>
                            <th>@lang('app.nim')</th>
                            <th>@lang('app.ipk')</th>
                            <th>@lang('app.thesis_title')</th>
                            <th>@lang('app.graduate_date')</th>
                        </tr>
                    </thead>
                    </table>
                <!-- END: Datatable -->
                </div>
            </div>
            <!-- END: Latest Graduate List -->
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


    
    <!-- END: No data -->
@endsection

@section('page-js')

@endsection
@section('scripts')
<script>
    $("button").click(function() {
        $('html,body').animate({
            scrollTop: $(".second").offset().top},
            'slow');
    });
</script>
<script>
    $( document ).ready(function() {
        var internalData = [250, 50, 50, 75];

        var graphColors = [];
        var graphOutlines = [];
        var hoverColor = [];

        var internalDataLength = internalData.length;
        i = 0;

        while (i <= internalDataLength) {
            var randomR = Math.floor((Math.random() * 130) + 100);
            var randomG = Math.floor((Math.random() * 130) + 100);
            var randomB = Math.floor((Math.random() * 130) + 100);
          
            var graphBackground = "rgb(" 
                    + randomR + ", " 
                    + randomG + ", " 
                    + randomB + ")";
            graphColors.push(graphBackground);
            
            var graphOutline = "rgb(" 
                    + (randomR - 80) + ", " 
                    + (randomG - 80) + ", " 
                    + (randomB - 80) + ")";
            graphOutlines.push(graphOutline);
            
            var hoverColors = "rgb(" 
                    + (randomR + 25) + ", " 
                    + (randomG + 25) + ", " 
                    + (randomB + 25) + ")";
            hoverColor.push(hoverColors);
            
          i++;
        };

        var ctx = document.querySelector("#applyed").getContext("2d");
        window.myBar = new Chart(ctx, {
          type: 'pie',
          data: {
            labels: {!!$nama_applyed!!},
            datasets: [{
              data: {!!$jumlah_applyed!!},
              backgroundColor: ["#FF8B26", "#FFC533", "#285FD3", "#d3285f", '#91c714'],
              hoverBackgroundColor: ["#FF8B26", "#FFC533", "#285FD3", "#d3285f", '#91c714'],
              borderWidth: 5,
              borderColor: $('html').hasClass('dark') ? '#303953' : '#fff'
            }]
          },
          options: {
            legend: {
              display: false
            }
          }
        });

        var ctx = document.querySelector("#views").getContext("2d");
        window.myBar = new Chart(ctx, {
          type: 'pie',
          data: {
            labels: {!!$nama_view!!},
            datasets: [{
              data: {!!$jumlah_view!!},
              backgroundColor: ["#FF8B26", "#FFC533", "#285FD3", "#d3285f", '#91c714'],
              hoverBackgroundColor: ["#FF8B26", "#FFC533", "#285FD3", "#d3285f", '#91c714'],
              borderWidth: 5,
              borderColor: $('html').hasClass('dark') ? '#303953' : '#fff'
            }]
          },
          options: {
            legend: {
              display: false
            }
          }
        });

        var ctx = document.querySelector("#jobs").getContext("2d");
        window.myBar = new Chart(ctx, {
          type: 'pie',
          data: {
            labels: {!!$nama_job!!},
            datasets: [{
              data: {!!$jumlah_job!!},
              backgroundColor: ["#FF8B26", "#FFC533", "#285FD3", "#d3285f", '#91c714'],
              hoverBackgroundColor: ["#FF8B26", "#FFC533", "#285FD3", "#d3285f", '#91c714'],
              borderWidth: 5,
              borderColor: $('html').hasClass('dark') ? '#303953' : '#fff'
            }]
          },
          options: {
            legend: {
              display: false
            }
          }
        });
    });
</script>
<script>
    var ctx = document.querySelector("#chartContainer").getContext("2d");
    $( ".dropdown" ).change(function() {
        var e = document.getElementById("dd");
        var dd = e.options[e.selectedIndex].value;

        var url = "https://midone1.dev/dashboard/json_chart/"+dd;
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            contentType: "application/json",
            success:function(data) {
                let total = Object.values(data).map(x=>x.total);
                console.log(JSON.stringify(total));

                window.myBar = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ["January","February","March","April","May","June","July","August","September","October","November","December"],
                            datasets: [{
                                label: '# of Applicants',
                                data: total,
                                borderWidth: 2,
                                borderColor: '#3160D8',
                                backgroundColor: 'transparent',
                                pointBorderColor: 'transparent'
                            }]
                        },
                        options: {
                            legend: {
                                display: false
                            },
                            scales: {
                                xAxes: [{
                                    ticks: {
                                        fontSize: '12',
                                        fontColor: $('html').hasClass('dark') ? '#718096' : '#777777'
                                    },
                                    gridLines: {
                                        display: false
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        fontSize: '12',
                                        fontColor: $('html').hasClass('dark') ? '#718096' : '#777777',
                                        callback: function(value, index, values) {
                                            return value
                                        }
                                    },
                                    gridLines: {
                                        color: $('html').hasClass('dark') ? '#718096' : '#D8D8D8',
                                        zeroLineColor: $('html').hasClass('dark') ? '#718096' : '#D8D8D8',
                                        borderDash: [2, 2],
                                        zeroLineBorderDash:  [2, 2],
                                        drawBorder: false
                                    }
                                }]
                            }
                        }
                    });
            } 
        });
    });
</script>
<script>
    $( "#progdi_latest_graduate_list" ).change(function() {
        var e = document.getElementById("progdi_latest_graduate_list");
        var ee = e.options[e.selectedIndex].value;

        $('#latest_graduate_list').DataTable( {
            responsive: true,
            dom: 'lBfrtip',
            destroy: true,
            pageLength : 5,
            lengthMenu: [5, 10],
            ajax: {
                url: "https://midone1.dev/dashboard/json_lulus/"+ee,
                type: 'GET'
            },
            columns: [
                { data: "nama" },
                { data: "nim" },
                { data: "ipk" },
                { data: "judul_skripsi" },
                { data: "tanggal_lulus" }
            ],
            order: [
                [ 2, "desc" ]
            ],
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        }
        );
    });
</script>
<script>
    $( "#progdi_top_student_list" ).change(function() {
        var e = document.getElementById("progdi_top_student_list");
        var ee = e.options[e.selectedIndex].value;

        var z = document.getElementById("class_top_student_list");
        var zz = z.options[z.selectedIndex].value;


        $('#top_student_list').DataTable( {
            responsive: true,
            dom: 'lBfrtip',
            destroy: true,
            pageLength : 5,
            lengthMenu: [5, 10],
            ajax: {
                url: "https://midone1.dev/dashboard/json_top_student/"+ee+"/"+zz,
                type: 'GET'
            },
            columns: [
                { data: "nama" },
                { data: "nim" },
                { data: "ipk" },
                { data: 'nim', render : function ( data, type, row, meta ) {
                    var html = data.replace(".", "").replace(".", "")
                    var email = html.toLowerCase()+'@student.unika.ac.id'
                    var button = '<a class="button flex items-center justify-center bg-theme-9 text-white" href="https://mail.google.com/mail/?view=cm&fs=1&to='+email+'&su=&body=&bcc=vanika@unika.ac.id" target="_blank">Send Email</a>'
                    return button
                }},
            ],
            order: [
                [ 2, "desc" ]
            ],
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        }
        );
    } 
    );

    $( "#class_top_student_list" ).change(function() {
        var e = document.getElementById("progdi_top_student_list");
        var ee = e.options[e.selectedIndex].value;

        var z = document.getElementById("class_top_student_list");
        var zz = z.options[z.selectedIndex].value;


        $('#top_student_list').DataTable( {
            responsive: true,
            dom: 'Bfrtip',
            destroy: true,
            pageLength : 5,
            ajax: {
                url: "https://midone1.dev/dashboard/json_top_student/"+ee+"/"+zz,
                type: 'GET'
            },
            columns: [
                { data: "nama" },
                { data: "nim" },
                { data: "ipk" },
                { data: 'nim', render : function ( data, type, row, meta ) {
                    var html = data.replace(".", "").replace(".", "")
                    var email = html.toLowerCase()+'@student.unika.ac.id'
                    var button = '<a class="button flex items-center justify-center bg-theme-9 text-white" href="https://mail.google.com/mail/?view=cm&fs=1&to='+email+'&su=&body=&bcc=vanika@unika.ac.id" target="_blank">Send Email</a>'
                    return button
                }},
            ],
            order: [
                [ 2, "desc" ]
            ],
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        }
        );
    });
</script>
<script>
    $( "#progdi_latest_graduate_list_faculty" ).change(function() {
        var e = document.getElementById("progdi_latest_graduate_list_faculty");
        var ee = e.options[e.selectedIndex].value;

        $('#latest_graduate_list_faculty').DataTable( {
            responsive: true,
            dom: 'lBfrtip',
            destroy: true,
            pageLength : 5,
            lengthMenu: [5, 10],
            ajax: {
                url: "https://midone1.dev/dashboard/json_lulus/"+ee,
                type: 'GET'
            },
            columns: [
                { data: "nama" },
                { data: "nim" },
                { data: "ipk" },
                { data: "judul_skripsi" },
                { data: "tanggal_lulus" }
            ],
            order: [
                [ 2, "desc" ]
            ],
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        }
        );
    });
</script>
<script>
    $( "#progdi_certificate_faculty" ).change(function() {
        var e = document.getElementById("progdi_certificate_faculty");
        var ee = e.options[e.selectedIndex].value;

        $('#certificate_faculty').DataTable( {
            responsive: true,
            dom: 'lBfrtip',
            destroy: true,
            pageLength : 5,
            lengthMenu: [5, 10],
            ajax: {
                url: "https://midone1.dev/dashboard/json_certificate_progdi/"+ee,
                type: 'GET'
            },
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "nim" },
                { data: "progdi" },
                { data: 'id', render : function ( data, type, row, meta ) {
                    var id = data
                    var target = "https://midone1.dev/final/"+id+"/pdf"
                    var button = '<a class="button flex items-center justify-center bg-theme-9 text-white" href="'+target+'" target="_blank">Send Email</a>'
                    return button
                }},
            ],
            order: [
                [ 0, "desc" ]
            ],
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        }
        );
    });
</script>
<script>
    $( "#progdi_top_student_list_faculty" ).change(function() {
        var e = document.getElementById("progdi_top_student_list_faculty");
        var ee = e.options[e.selectedIndex].value;

        var z = document.getElementById("class_top_student_list_faculty");
        var zz = z.options[z.selectedIndex].value;


        $('#top_student_list_faculty').DataTable( {
            responsive: true,
            dom: 'lBfrtip',
            destroy: true,
            pageLength : 5,
            lengthMenu: [5, 10],
            ajax: {
                url: "https://midone1.dev/dashboard/json_top_student/"+ee+"/"+zz,
                type: 'GET'
            },
            columns: [
                { data: "nama" },
                { data: "nim" },
                { data: "ipk" },
                { data: 'nim', render : function ( data, type, row, meta ) {
                    var html = data.replace(".", "").replace(".", "")
                    var email = html.toLowerCase()+'@student.unika.ac.id'
                    var button = '<a class="button flex items-center justify-center bg-theme-9 text-white" href="https://mail.google.com/mail/?view=cm&fs=1&to='+email+'&su=&body=&bcc=vanika@unika.ac.id" target="_blank">Send Email</a>'
                    return button
                }},
            ],
            order: [
                [ 2, "desc" ]
            ],
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        }
        );
    });

    $( "#class_top_student_list_faculty" ).change(function() {
        var e = document.getElementById("progdi_top_student_list_faculty");
        var ee = e.options[e.selectedIndex].value;

        var z = document.getElementById("class_top_student_list_faculty");
        var zz = z.options[z.selectedIndex].value;


        $('#top_student_list_faculty').DataTable( {
            responsive: true,
            dom: 'Bfrtip',
            destroy: true,
            pageLength : 5,
            ajax: {
                url: "https://midone1.dev/dashboard/json_top_student/"+ee+"/"+zz,
                type: 'GET'
            },
            columns: [
                { data: "nama" },
                { data: "nim" },
                { data: "ipk" },
                { data: 'nim', render : function ( data, type, row, meta ) {
                    var html = data.replace(".", "").replace(".", "")
                    var email = html.toLowerCase()+'@student.unika.ac.id'
                    var button = '<a class="button flex items-center justify-center bg-theme-9 text-white" href="https://mail.google.com/mail/?view=cm&fs=1&to='+email+'&su=&body=&bcc=vanika@unika.ac.id" target="_blank">Send Email</a>'
                    return button
                }},
            ],
            order: [
                [ 2, "desc" ]
            ],
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        }
        );
    });
</script>
@endsection