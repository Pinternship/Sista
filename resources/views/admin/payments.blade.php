@extends('layouts.dashboard')


@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
            <button class="button text-white bg-theme-1 shadow-md mr-2">@lang('app.pricing')</button>
            <div class="dropdown relative">
                <button class="dropdown-toggle button px-2 box text-gray-700">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                </button>
                <div class="dropdown-box mt-10 absolute w-40 top-0 left-0 z-20">
                    <div class="dropdown-box__content box p-2">
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print </a>
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                    </div>
                </div>
            </div>
            <div class="hidden md:block mx-auto text-gray-600">@lang('app.total') : {{$payments->total()}}</div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <form class="form-inline" method="get" action="">
                <div class="w-56 relative text-gray-700">
                    <input type="text" name="q" value="{{request('q')}}" class="input w-56 box pr-10 placeholder-theme-13" placeholder="@lang('app.payer_email')">
                    <button type="submit" class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></button>
                </div>
                 </form>
            </div>
        </div>

        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            @if($payments->count() > 0)
            <table class="table table-report -mt-2">
                <thead>
                    <th>@lang('app.no')</th>
                    <th>@lang('app.name')</th>
                    <th>@lang('app.payer_email')</th>
                    <th>@lang('app.amount')</th>
                    <th>@lang('app.method')</th>
                    <th>@lang('app.time')</th>
                    <th>#</th>
                </thead>
            @foreach($payments as $key => $payment)
            <tbody>
                <tr>
                    <td>
                        {{ $payments->firstItem() + $key }}
                    </td>
                    <td>
                        <a href="{{route('payment_view', $payment->id)}}">
                            <i class="la la-user"></i> {{$payment->user->name}} <br />
                            <i class="la la-building-o"></i> {{$payment->user->company}}
                        </a>
                    </td>
                    <td><a href="{{route('payment_view', $payment->id)}}"> {{$payment->email}} </a></td>
                    <td>{!! get_amount($payment->amount) !!}</td>
                    <td>{{$payment->payment_method}}</td>
                    <td><span data-toggle="tooltip" title="{{$payment->created_at->format('F d, Y h:i a')}}">{{$payment->created_at->format('F d, Y')}}</span></td>

                    <td>
                        @if(auth()->user()->is_admin())
                            @if($payment->status == 'success')
                                <button class="tooltip button px-2 mr-1 mb-2 bg-theme-6 text-white" title="@lang("app.remove")">
                                    <a href="{{route('status_change', [$payment->id, 'declined'] )}}">
                                    <span class="w-5 h-5 flex items-center justify-center">
                                        <i class="fal fa-times-circle w-4 h-4"></i>
                                    </span>
                                    </a>
                                </button>
                            @else
                                <button class="tooltip button px-2 mr-1 mb-2 bg-theme-9 text-white" title="@lang("app.approved")">
                                    <a href="{{route('status_change', [$payment->id, 'success'] )}}">
                                    <span class="w-5 h-5 flex items-center justify-center">
                                        <i class="fal fa-check-circle w-4 h-4"></i>
                                    </span>
                                    </a>
                                </button>
                            @endif
                        @else
                                @if($payment->status == 'success')
                                    <button class="tooltip button px-2 mr-1 mb-2 bg-theme-9 text-white" title="@lang("app.approved")">
                                        <span class="w-5 h-5 flex items-center justify-center">
                                            <i class="fal fa-check-circle w-4 h-4"></i>
                                        </span>
                                        </a>
                                    </button>
                                @else
                                    <button class="tooltip button px-2 mr-1 mb-2 bg-theme-6 text-white" title="@lang("app.blocked")">
                                        <span class="w-5 h-5 flex items-center justify-center">
                                            <i class="fal fa-times-circle w-4 h-4"></i>
                                        </span>
                                        </a>
                                    </button>
                                @endif
                        @endif
                            <button class="tooltip button px-2 mr-1 mb-2 bg-theme-3 text-white" title="@lang("app.view")">
                                <a href="{{route('payment_view', $payment->id)}}">
                                <span class="w-5 h-5 flex items-center justify-center">
                                    <i class="fal fa-eye w-4 h-4"></i>
                                </span>
                                </a>
                            </button>
                    </td>
                </tr>
            </tbody>
            @endforeach
            </table>
            {!! $payments->links('vendor.pagination.tailwind') !!}
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