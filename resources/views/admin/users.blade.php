@extends('layouts.dashboard')

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        {{$users->total()}} @lang('app.total_users_found')
    </h2>

    @if($user->is_admin())
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <a href="{{route('new_register')}}" class="button text-white bg-theme-1 shadow-md mr-2" target="_blank">Add New User</a>
        <div class="dropdown relative ml-auto sm:ml-0">
            <button class="dropdown-toggle button px-2 box text-gray-700">
                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
            </button>
            <div class="dropdown-box mt-10 absolute w-40 top-0 right-0 z-20">
                <div class="dropdown-box__content box p-2">
                    <a href="{{route('register_employer')}}" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md" target="_blank"> <i data-feather="users" class="w-4 h-4 mr-2"></i> Add Employer </a>
                    <a href="{{route('register_faculty')}}" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md" target="_blank"> <i data-feather="message-circle" class="w-4 h-4 mr-2"></i> Add Faculty </a>
                </div>
            </div>
        </div>
    </div>
    @elseif($user->is_faculty())
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <a href="{{route('register_employer')}}" class="button text-white bg-theme-1 shadow-md mr-2" target="_blank">Add New User</a>
    </div>
    @endif
</div>
<!-- BEGIN: Datatable -->
@if($users->count() > 0)
<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full">
        <thead>
            <tr>
                <th class="border-b-2 whitespace-no-wrap">@lang('app.name')</th>
                <th class="border-b-2 whitespace-no-wrap">@lang('app.email')</th>
                <th class="border-b-2 whitespace-no-wrap">@lang('app.user_type')</th>
                <th class="border-b-2 whitespace-no-wrap">@lang('app.status')</th>
                <th class="border-b-2 whitespace-no-wrap">@lang('app.actions')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="border-b">
                    {{ $user->name }}
                </td>
                <td class="border-b">
                    {{$user->email}}
                </td>
                <td class="border-b">
                    {{$user->user_type}}
                </td>
                <td class="border-b">
                    @if ($user->active_status == 1)
                        <p class="text-green-500">@lang('app.active')</p>
                    @elseif($user->active_status == 2)
                        <p class="text-red-500">@lang('app.blocked')</p>
                    @elseif($user->active_status == 4)
                        <p class="text-red-500">@lang('app.deleted')</p>
                    @else
                        <p class="text-yellow-500">@lang('app.pending')</p>
                    @endif
                </td>
                <td class="border-b">
                    <button class="tooltip button px-2 mr-1 mb-2 bg-theme-3 text-white" title="@lang("app.view")">
                        <a href="{{route('users_view', $user->id)}}" target="_blank">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="fal fa-eye w-4 h-4"></i>
                        </span>
                        </a>
                    </button>
                    @if($user->active_status == 0)
                        <button class="tooltip button px-2 mr-1 mb-2 bg-theme-9 text-white" title="@lang("app.approved")">
                            <a href="{{route('user_status', [$user->id, 'approve'])}}">
                            <span class="w-5 h-5 flex items-center justify-center">
                                <i class="fal fa-check-circle w-4 h-4"></i>
                            </span>
                            </a>
                        </button>

                        <button class="tooltip button px-2 mr-1 mb-2 bg-theme-12 text-white" title="@lang("app.blocked")">
                            <a href="{{route('user_status', [$user->id, 'block'])}}">
                            <span class="w-5 h-5 flex items-center justify-center">
                                <i class="fal fa-ban w-4 h-4"></i>
                            </span>
                            </a>
                        </button>
                    @elseif($user->active_status == 1)
                        <button class="tooltip button px-2 mr-1 mb-2 bg-theme-12 text-white" title="@lang("app.blocked")">
                            <a href="{{route('user_status', [$user->id, 'block'])}}">
                            <span class="w-5 h-5 flex items-center justify-center">
                                <i class="fal fa-ban w-4 h-4"></i>
                            </span>
                            </a>
                        </button>
                    @elseif($user->active_status == 2)
                        <button class="tooltip button px-2 mr-1 mb-2 bg-theme-9 text-white" title="@lang("app.approved")">
                            <a href="{{route('user_status', [$user->id, 'approve'])}}">
                            <span class="w-5 h-5 flex items-center justify-center">
                                <i class="fal fa-check-circle w-4 h-4"></i>
                            </span>
                            </a>
                        </button>
                    @endif
                     <button class="tooltip button px-2 mr-1 mb-2 border text-gray-700" title="@lang("app.edit")">
                        <a href="{{route('users_edit', $user->id)}}" target="_blank">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="fal fa-edit w-4 h-4"></i>
                        </span>
                        </a>
                    </button>

                    @if($user->active_status != 4)
                        <button class="tooltip button px-2 mr-1 mb-2 border bg-theme-6 text-white" title="@lang("app.delete")">
                            <a href="{{route('user_status', [$user->id, 'delete'])}}">
                            <span class="w-5 h-5 flex items-center justify-center">
                                <i class="fal fa-trash-alt w-4 h-4"></i>
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
@endif
<!-- END: Datatable -->
@endsection

@section('page-js')

@endsection

@section('scripts')

<script type="text/javascript">

</script>

@endsection