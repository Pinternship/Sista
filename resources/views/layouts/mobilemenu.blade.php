<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="{{ route('dashboard') }}" class="flex mr-auto">
            <img alt="Smart Internship System Unika Soegijapranata Dashboard" class="w-6" src="{{asset('assets/images/logoonly.png')}}">
        </a>
        <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>
    <ul class="border-t border-theme-24 py-5 hidden">

        <li>
            <a href="{{route('dashboard')}}" class="{{ request()->is('dashboard')? 'menu menu--active' : 'menu' }}">
                <span class="menu__icon"><i data-feather="home"></i> </span>
                <span class="menu__title">@lang('app.dashboard')</span>
            </a>
        </li>
        @if($user->is_admin())
            <li>
                <a href="{{route('applied_jobs')}}" class="{{ request()->is('dashboard/u/applied-jobs*')? 'menu menu--active' : 'menu' }}">
                    <span class="menu__icon"><i data-feather="archive"></i> </span>
                    <span class="menu__title">@lang('app.applied_jobs')</span>
                </a>
            </li>
        @elseif($user->is_user())
            <li>
                <a href="{{route('applied_jobs')}}" class="{{ request()->is('dashboard/u/applied-jobs*')? 'menu menu--active' : 'menu' }}">
                    <span class="menu__icon"><i data-feather="archive"></i> </span>
                    <span class="menu__title">@lang('app.applied_jobs')</span>
                </a>
            </li>

            <li>
                <a href="javascript:;" class="{{ request()->is('dashboard/report*')? 'menu menu--active' : 'menu' }}">
                    <div class="menu__icon"> <i data-feather="clipboard"></i> </div>
                    <div class="menu__title"> @lang('app.report') <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>

                <ul class="{{ request()->is('dashboard/report*')? 'menu__sub-open' : '' }}">
                    <li>
                        <a class="{{ request()->is('dashboard/report/final')? 'menu menu--active' : 'menu' }}" href="{{route('report_final_user')}}">
                            <div class="menu__icon"> <i data-feather="clipboard"></i> </div>
                            <div class="menu__title"> @lang('app.report_akhir') </div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if( $user->is_admin() or $user->is_employer() )
            <li>
                <a href="javascript:;" class="{{ request()->is('dashboard/employer*')? 'menu menu--active' : 'menu' }}">
                    <div class="menu__icon"> <i data-feather="book"></i> </div>
                    <div class="menu__title"> @lang('app.employer') <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>

                <ul class="{{ request()->is('dashboard/employer*')? 'menu__sub-open' : '' }}">
                    <li><a class="{{ request()->is('dashboard/employer/job/new')? 'menu menu--active' : 'menu' }}" href="{{route('post_new_job')}}">@lang('app.post_new_job')</a></li>
                    <li><a class="{{ request()->is('dashboard/employer/job/posted')? 'menu menu--active' : 'menu' }}" href="{{route('posted_jobs')}}">@lang('app.posted_jobs')</a></li>
                    <li><a class="{{ request()->is('dashboard/employer/applicant')? 'menu menu--active' : 'menu' }}" href="{{route('employer_applicant')}}">@lang('app.applicants')</a></li>
                    <li><a class="{{ request()->is('dashboard/employer/shortlisted')? 'menu menu--active' : 'menu' }}" href="{{route('shortlisted_applicant')}}">@lang('app.shortlist')</a></li>
                    <li><a class="{{ request()->is('dashboard/employer/accept')? 'menu menu--active' : 'menu' }}" href="{{route('accepted_applicant')}}">@lang('app.accept')</a></li>
                    <li><a class="{{ request()->is('dashboard/employer/profile')? 'menu menu--active' : 'menu' }}" href="{{route('employer_profile')}}">@lang('app.profile')</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="{{ request()->is('dashboard/report*')? 'menu menu--active' : 'menu' }}">
                    <div class="menu__icon"> <i data-feather="clipboard"></i> </div>
                    <div class="menu__title"> @lang('app.report') <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>

                <ul class="{{ request()->is('dashboard/report*')? 'menu__sub-open' : '' }}">
                    <li><a class="{{ request()->is('dashboard/report/monthly')? 'menu menu--active' : 'menu' }}" href="{{route('report_monthly')}}">@lang('app.report_perusahaan_bulanan')</a></li>
                    <li><a class="{{ request()->is('dashboard/report/final')? 'menu menu--active' : 'menu' }}" href="{{route('report_final')}}">@lang('app.report_akhir')</a></li>
                </ul>
            </li>
        @endif

        @if (! $user->is_user() )
            <li>
                <a href="{{route('payments')}}" class="{{ request()->is('dashboard/payments*')? 'menu menu--active' : 'menu' }}">
                    <div class="menu__icon"> <i data-feather="credit-card"></i> </div>
                    <span class="menu__title"> @lang('app.payments') </span>
                </a>
            </li>
        @endif

        <li class="nav__devider my-6"></li>

        @if($user->is_admin())
            <li>
                <a href="{{route('users')}}" class="{{ request()->is('dashboard/u/users*')? 'menu menu--active' : 'menu' }}">
                    <div class="menu__icon"> <i data-feather="users"></i> </div>
                    <span class="menu__title"> @lang('app.users') </span>
                </a>
            </li>
            <li>
                <a href="{{route('dashboard_categories')}}" class="{{ request()->is('dashboard/categories*')? 'menu menu--active' : 'menu' }}">
                    <div class="menu__icon"> <i data-feather="columns"></i> </div>
                    <span class="menu__title">@lang('app.categories')</span>
                </a>
            </li>
        @endif

        @if($user->is_admin())
            <li>
                <a href="javascript:;" class="{{ request()->is('dashboard/jobs*')? 'menu menu--active' : 'menu' }}">
                    <div class="menu__icon"> <i data-feather="list"></i> </div>
                    <div class="menu__title"> @lang('app.jobs') <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>

                <ul class="{{ request()->is('dashboard/jobs*')? 'menu__sub-open' : '' }}">
                    <li>
                        <a class="{{ request()->is('dashboard/jobs')? 'menu menu--active' : 'menu' }}" href="{{route('pending_jobs')}}">@lang('app.pending') 
                            <span class="badge badge-success float-right">{{$pendingJobCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ request()->is('dashboard/jobs/pending')? 'menu menu--active' : 'menu' }}" href="{{route('approved_jobs')}}">@lang('app.approved') 
                            <span class="badge badge-success float-right">{{$approvedJobCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ request()->is('dashboard/jobs/blocked')? 'menu menu--active' : 'menu' }}" href="{{route('blocked_jobs')}}">@lang('app.blocked') 
                            <span class="badge badge-success float-right">{{$blockedJobCount}}</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="{{ request()->is('dashboard/kerjasama*')? 'menu menu--active' : 'menu' }}">
                    <div class="menu__icon"> <i data-feather="edit-3"></i> </div>
                    <div class="menu__title"> @lang('app.kerjasama') <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>

                <ul class="{{ request()->is('dashboard/kerjasama*')? 'menu__sub-open' : '' }}">
                    <li><a class="{{ request()->is('dashboard/kerjasama/listperusahaan')? 'menu menu--active' : 'menu' }}" href="{{route('list_perusahaan')}}">@lang('app.list_perusahaan')</a></li>
                    <li><a class="{{ request()->is('dashboard/kerjasama/rekap')? 'menu menu--active' : 'menu' }}" href="{{route('report_final_user')}}">@lang('app.rekap')</a></li>
                </ul>
            </li>

            <li>
                <a href="{{route('flagged_jobs')}}" class="{{ request()->is('dashboard/flagged*')? 'menu menu--active' : 'menu' }}">
                    <div class="menu__icon"> <i data-feather="flag"></i> </div>
                    <span class="menu__title"> @lang('app.flagged_jobs') </span>
                </a>
            </li>

            <li>
               <a href="javascript:;" class="{{ request()->is('dashboard/cms*')? 'menu menu--active' : 'menu' }}">
                    <div class="menu__icon"> <i data-feather="heart"></i> </div>
                    <div class="menu__title"> @lang('app.cms') <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>

                <ul class="{{ request()->is('dashboard/cms*')? 'menu__sub-open' : '' }}">
                    <li><a class="{{ request()->is('dashboard/cms')? 'menu menu--active' : 'menu' }}" href="{{route('pages')}}">@lang('app.pages')</a></li>
                    <li><a class="{{ request()->is('dashboard/cms/posts')? 'menu menu--active' : 'menu' }}" href="{{route('posts')}}">@lang('app.posts')</a></li>
                </ul>
            </li>


            <li>
               <a href="javascript:;" class="{{ request()->is('dashboard/settings*')? 'menu menu--active' : 'menu' }}">
                    <div class="menu__icon"> <i data-feather="settings"></i> </div>
                    <div class="menu__title"> @lang('app.settings') <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>

                <ul class="{{ request()->is('dashboard/settings*')? 'menu__sub-open' : '' }}">
                    <li><a class="{{ request()->is('dashboard/settings')? 'menu menu--active' : 'menu' }}" href="{{route('general_settings')}}">@lang('app.general_settings')</a></li>
                    <li><a class="{{ request()->is('dashboard/settings/pricing')? 'menu menu--active' : 'menu' }}" href="{{route('pricing_settings')}}">@lang('app.pricing')</a></li>
                    <li><a class="{{ request()->is('dashboard/settings/gateways')? 'menu menu--active' : 'menu' }}" href="{{route('gateways_settings')}}">@lang('app.gateways')</a></li>
                </ul>
            </li>
        @endif

        <li class="nav__devider my-6"></li>

        <li>
            <a href="{{route('profile')}}" class="{{ request()->is('dashboard/profile*')? 'menu menu--active' : 'menu' }}">
                <div class="menu__icon"> <i data-feather="user"></i> </div>
                <span class="menu__title"> @lang('app.profile') </span>
            </a>
        </li>

       <li>
            <a href="{{route('change_password')}}" class="{{ request()->is('dashboard/account*')? 'menu menu--active' : 'menu' }}">
                <div class="menu__icon"> <i data-feather="lock"></i> </div>
                <span class="menu__title"> @lang('app.change_password') </span>
            </a>
        </li>

        <li>
            <a href="{{ route('logout') }}" class="{{ request()->is('logout')? 'menu menu--active' : 'menu' }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="menu__icon"> <i data-feather="log-out"></i> </div>
                <span class="menu__title"> @lang('app.logout') </span>
            </a>
        </li>
        <li class="nav__devider my-6"></li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" >
        @csrf
    </form>
</div>