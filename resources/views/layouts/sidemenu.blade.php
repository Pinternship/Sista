<nav class="side-nav">
    <a href="{{ route('dashboard') }}" class="intro-x flex items-center pl-5 pt-4">
        <img alt="Smart Internship System Unika Soegijapranata Dashboard" class="w-6" src="{{asset('assets/images/logoonly.png')}}">
        <span class="hidden xl:block text-white text-lg ml-3"> SI<span class="font-medium">STA</span> </span>
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>

        <li>
            <a href="{{route('dashboard')}}" class="{{ request()->is('dashboard')? 'side-menu side-menu--active' : 'side-menu' }}">
                <span class="side-menu__icon"><i data-feather="home"></i> </span>
                <span class="side-menu__title">@lang('app.dashboard')</span>
            </a>
        </li>

        @if($user->is_admin())
            <li>
                <a href="{{route('applied_jobs')}}" class="{{ request()->is('dashboard/u/applied-jobs*')? 'side-menu side-menu--active' : 'side-menu' }}">
                    <span class="side-menu__icon"><i data-feather="archive"></i> </span>
                    <span class="side-menu__title">@lang('app.applied_jobs')</span>
                </a>
            </li>
        @elseif($user->is_user())
            <li>
                <a href="{{route('applied_jobs')}}" class="{{ request()->is('dashboard/u/applied-jobs*')? 'side-menu side-menu--active' : 'side-menu' }}">
                    <span class="side-menu__icon"><i data-feather="archive"></i> </span>
                    <span class="side-menu__title">@lang('app.applied_jobs')</span>
                </a>
            </li>

            <li>
                <a href="javascript:;" class="{{ request()->is('dashboard/report*')? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon"> <i data-feather="clipboard"></i> </div>
                    <div class="side-menu__title"> @lang('app.report') <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
                </a>

                <ul class="{{ request()->is('dashboard/report*')? 'side-menu__sub-open' : '' }}">
                    <li>
                        <a class="{{ request()->is('dashboard/report/final')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('report_final_user')}}">
                            <div class="side-menu__icon"> <i data-feather="clipboard"></i> </div>
                            <div class="side-menu__title"> @lang('app.report_akhir') </div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if( $user->is_admin() or $user->is_employer() )
            <li>
                <a href="javascript:;" class="{{ request()->is('dashboard/employer*')? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon"> <i data-feather="book"></i> </div>
                    <div class="side-menu__title"> @lang('app.employer') <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
                </a>

                <ul class="{{ request()->is('dashboard/employer*')? 'side-menu__sub-open' : '' }}">
                    <li><a class="{{ request()->is('dashboard/employer/job/new')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('post_new_job')}}">@lang('app.post_new_job')</a></li>
                    <li><a class="{{ request()->is('dashboard/employer/job/posted')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('posted_jobs')}}">@lang('app.posted_jobs')</a></li>
                    <li><a class="{{ request()->is('dashboard/employer/applicant')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('employer_applicant')}}">@lang('app.applicants')</a></li>
                    <li><a class="{{ request()->is('dashboard/employer/shortlisted')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('shortlisted_applicant')}}">@lang('app.shortlist')</a></li>
                    <li><a class="{{ request()->is('dashboard/employer/accept')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('accepted_applicant')}}">@lang('app.accept')</a></li>
                    <li><a class="{{ request()->is('dashboard/employer/profile')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('employer_profile')}}">@lang('app.profile')</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="{{ request()->is('dashboard/report*')? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon"> <i data-feather="clipboard"></i> </div>
                    <div class="side-menu__title"> @lang('app.report') <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
                </a>

                <ul class="{{ request()->is('dashboard/report*')? 'side-menu__sub-open' : '' }}">
                    <li><a class="{{ request()->is('dashboard/report/monthly')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('report_monthly')}}">@lang('app.report_perusahaan_bulanan')</a></li>
                    <li><a class="{{ request()->is('dashboard/report/final')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('report_final')}}">@lang('app.report_akhir')</a></li>
                </ul>
            </li>

            <li>
                <a href="{{route('payments')}}" class="{{ request()->is('dashboard/payments*')? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon"> <i data-feather="credit-card"></i> </div>
                    <span class="side-menu__title"> @lang('app.payments') </span>
                </a>
            </li>
            <li class="side-nav__devider my-6"></li>
        @endif

        @if($user->is_faculty() )
            <li class="side-nav__devider my-6"></li>
            <li>
                <a href="{{route('users')}}" class="{{ request()->is('dashboard/u/users*')? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                    <span class="side-menu__title"> @lang('app.users') </span>
                </a>
            </li>

            <li>
                <a href="javascript:;" class="{{ request()->is('dashboard/report*')? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon"> <i data-feather="clipboard"></i> </div>
                    <div class="side-menu__title"> @lang('app.report') <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
                </a>

                <ul class="{{ request()->is('dashboard/report*')? 'side-menu__sub-open' : '' }}">
                    <li><a class="{{ request()->is('dashboard/report/monthly_faculty')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('report_monthly_faculty')}}">@lang('app.report_perusahaan_bulanan')</a></li>
                    <li><a class="{{ request()->is('dashboard/report/final_faculty')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('report_final_faculty')}}">@lang('app.report_akhir')</a></li>
                </ul>
            </li>
            <li class="side-nav__devider my-6"></li>
        @endif

        
        @if($user->is_admin())
            <li>
                <a href="{{route('users')}}" class="{{ request()->is('dashboard/u/users*')? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                    <span class="side-menu__title"> @lang('app.users') </span>
                </a>
            </li>
            <li>
                <a href="{{route('dashboard_categories')}}" class="{{ request()->is('dashboard/categories*')? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon"> <i data-feather="columns"></i> </div>
                    <span class="side-menu__title">@lang('app.categories')</span>
                </a>
            </li>
        @endif

        @if($user->is_admin())
            <li>
                <a href="javascript:;" class="{{ request()->is('dashboard/jobs*')? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon"> <i data-feather="list"></i> </div>
                    <div class="side-menu__title"> @lang('app.jobs') <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
                </a>

                <ul class="{{ request()->is('dashboard/jobs*')? 'side-menu__sub-open' : '' }}">
                    <li>
                        <a class="{{ request()->is('dashboard/jobs')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('pending_jobs')}}">@lang('app.pending') 
                            <span class="badge badge-success float-right">{{$pendingJobCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ request()->is('dashboard/jobs/pending')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('approved_jobs')}}">@lang('app.approved') 
                            <span class="badge badge-success float-right">{{$approvedJobCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ request()->is('dashboard/jobs/blocked')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('blocked_jobs')}}">@lang('app.blocked') 
                            <span class="badge badge-success float-right">{{$blockedJobCount}}</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="{{ request()->is('dashboard/kerjasama*')? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon"> <i data-feather="edit-3"></i> </div>
                    <div class="side-menu__title"> @lang('app.kerjasama') <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
                </a>

                <ul class="{{ request()->is('dashboard/kerjasama*')? 'side-menu__sub-open' : '' }}">
                    <li><a class="{{ request()->is('dashboard/kerjasama/listperusahaan')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('list_perusahaan')}}">@lang('app.list_perusahaan')</a></li>
                    <li><a class="{{ request()->is('dashboard/kerjasama/rekap')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('report_final_user')}}">@lang('app.rekap')</a></li>
                </ul>
            </li>

            <li>
                <a href="{{route('flagged_jobs')}}" class="{{ request()->is('dashboard/flagged*')? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon"> <i data-feather="flag"></i> </div>
                    <span class="side-menu__title"> @lang('app.flagged_jobs') </span>
                </a>
            </li>

            <li>
               <a href="javascript:;" class="{{ request()->is('dashboard/cms*')? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon"> <i data-feather="heart"></i> </div>
                    <div class="side-menu__title"> @lang('app.cms') <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
                </a>

                <ul class="{{ request()->is('dashboard/cms*')? 'side-menu__sub-open' : '' }}">
                    <li><a class="{{ request()->is('dashboard/cms')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('pages')}}">@lang('app.pages')</a></li>
                    <li><a class="{{ request()->is('dashboard/cms/posts')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('posts')}}">@lang('app.posts')</a></li>
                </ul>
            </li>


            <li>
               <a href="javascript:;" class="{{ request()->is('dashboard/settings*')? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon"> <i data-feather="settings"></i> </div>
                    <div class="side-menu__title"> @lang('app.settings') <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
                </a>

                <ul class="{{ request()->is('dashboard/settings*')? 'side-menu__sub-open' : '' }}">
                    <li><a class="{{ request()->is('dashboard/settings')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('general_settings')}}">@lang('app.general_settings')</a></li>
                    <li><a class="{{ request()->is('dashboard/settings/pricing')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('pricing_settings')}}">@lang('app.pricing')</a></li>
                    <li><a class="{{ request()->is('dashboard/settings/gateways')? 'side-menu side-menu--active' : 'side-menu' }}" href="{{route('gateways_settings')}}">@lang('app.gateways')</a></li>
                </ul>
            </li>
            <li class="side-nav__devider my-6"></li>
        @endif
        

        <li>
            <a href="{{route('profile')}}" class="{{ request()->is('dashboard/profile*')? 'side-menu side-menu--active' : 'side-menu' }}">
                <div class="side-menu__icon"> <i data-feather="user"></i> </div>
                <span class="side-menu__title"> @lang('app.profile') </span>
            </a>
        </li>

       <li>
            <a href="{{route('change_password')}}" class="{{ request()->is('dashboard/account*')? 'side-menu side-menu--active' : 'side-menu' }}">
                <div class="side-menu__icon"> <i data-feather="lock"></i> </div>
                <span class="side-menu__title"> @lang('app.change_password') </span>
            </a>
        </li>

        <li>
            <a href="{{ route('logout') }}" class="{{ request()->is('logout')? 'side-menu side-menu--active' : 'side-menu' }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="side-menu__icon"> <i data-feather="log-out"></i> </div>
                <span class="side-menu__title"> @lang('app.logout') </span>
            </a>
        </li>
        <li class="side-nav__devider my-6"></li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" >
        @csrf
    </form>
</nav>