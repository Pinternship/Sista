<div class="top-bar">
    <!-- BEGIN: Breadcrumb -->
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="{{route("dashboard")}}" class="">Dashboard</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="" class="breadcrumb--active">{!! !empty($title) ? $title : 'Pages' !!}</a> </div>
    <!-- END: Breadcrumb -->
    <!-- BEGIN: Post new job -->
    @if((auth()->user()->is_admin()) or (auth()->user()->is_employer()))
        <div class="intro-x relative mr-3 sm:mr-6">
            <div class="search hidden sm:block">
                 <a class="button flex items-center justify-center bg-theme-9 text-white" href="{{route('post_new_job')}}"> <i data-feather="send" class="w-4 h-4 mr-2"></i> @lang('app.post_new_job')
                 </a>    
            </div>
            <a class="notification sm:hidden" href="{{route('post_new_job')}}">
                <i data-feather="send" class="notification__icon">
                </i>
            </a>
        </div>
    @endif
    <!-- END: Post new job -->
    <!-- BEGIN: Notifications -->
    <div class="intro-x dropdown relative mr-auto sm:mr-6">
        <div class="dropdown-toggle notification notification--bullet cursor-pointer"> <i data-feather="bell" class="notification__icon"></i> </div>
        <div class="notification-content dropdown-box mt-8 absolute top-0 left-0 sm:left-auto sm:right-0 z-20 -ml-10 sm:ml-0">
            <div class="notification-content__box dropdown-box__content box">
                <div class="notification-content__title">Notifications</div>

                @if(notification()->count() > 0)
                @foreach(notification() as $application)
                <div class="cursor-pointer relative flex items-center ">
                    <div class="w-12 h-12 flex-none image-fit mr-1">
                        <img alt="{{$application->name}}" class="rounded-full" src="{{$application->photo_url}}">
                        <div class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                    </div>
                    <div class="ml-2 overflow-hidden">
                        <div class="flex items-center">
                            <a href="javascript:;" class="font-medium truncate mr-5">{{$application->name}}</a> 
                            <div class="text-xs text-gray-500 ml-auto whitespace-no-wrap">{{$application->created_at->format(get_option('date_format'))}}</div>
                        </div>
                        <div class="w-full truncate text-gray-600">{{$application->job->job_title}}</div>
                    </div>
                </div>
                @endforeach
                @endif

            </div>
        </div>
    </div>
    <!-- END: Notifications -->
    <!-- BEGIN: Account Menu -->
    <div class="intro-x dropdown w-8 h-8 relative">
        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in">
            @if((auth()->user()->is_admin()) or (auth()->user()->is_employer()))
                <img alt="Midone Tailwind HTML Admin Template" src="{{ Auth::user()->logo_url }}">
            @else
                <img alt="Midone Tailwind HTML Admin Template" src="{{ Auth::user()->photo }}">
            @endif
        </div>
        <div class="dropdown-box mt-10 absolute w-56 top-0 right-0 z-20">
            <div class="dropdown-box__content box bg-theme-38 text-white">
                <div class="p-4 border-b border-theme-40">
                    <div class="font-medium">{{ Auth::user()->name }}
                        <span class="badge badge-warning">
                            <i class="fal fa-crown"></i> {{auth()->user()->premium_jobs_balance}}
                        </span>
                    </div>
                    <div class="text-xs text-theme-41">{{ Auth::user()->company }}</div>
                </div>
                <div class="p-2">
                    <a href="{{route('home')}}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md" target="_blank"> <i data-feather="home" class="w-4 h-4 mr-2"></i> @lang('app.view_site') </a>
                    <a href="{{route('profile')}}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> @lang('app.profile')  </a>
                    <a href="{{route('change_password')}}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="lock" class="w-4 h-4 mr-2"></i> @lang('app.change_password')  </a>
                </div>
                <div class="p-2 border-t border-theme-40">
                    <a href="{{ route('logout') }}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> @lang('app.logout') </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Account Menu -->
</div>