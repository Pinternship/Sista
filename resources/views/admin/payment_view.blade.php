@extends('layouts.dashboard')


@section('content')
<!-- BEGIN: Wizard Layout -->
<div class="intro-y box py-10 sm:py-20 mt-5">
    <div class="px-5 sm:px-20">
        <div class="font-medium text-base">@lang('app.payment_details')</div>
        <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
            <div class="intro-y col-span-12 sm:col-span-6">
                <div class="mb-2">@lang('app.payer_name')</div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6">
                <div class="mb-2">{{$payment->name}}</div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6">
                <div class="mb-2">@lang('app.payer_email')</div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6">
                <div class="mb-2">{!! get_amount($payment->amount) !!}</div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6">
                <div class="mb-2">@lang('app.method')</div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6">
                <div class="mb-2">{{$payment->payment_method}}</div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6">
                <div class="mb-2">@lang('app.currency')</div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6">
                <div class="mb-2">{{$payment->currency}}</div>
            </div>

            @if($payment->payment_method == 'stripe')
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">@lang('app.card_last4')</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">{{$payment->card_last4}}</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">@lang('app.card_id')</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">{{$payment->card_id}}</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">@lang('app.card_brand')</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">{{$payment->card_brand}}</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">@lang('app.card_expire')</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">{{$payment->card_exp_month}},{{$payment->card_exp_year}}</div>
                </div>  
            @endif

            @if($payment->payment_method == 'bank_transfer')
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">@lang('app.bank_swift_code')</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">{{$payment->bank_swift_code}}</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">@lang('app.account_number')</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">{{$payment->account_number}}</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">@lang('app.branch_name')</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">{{$payment->branch_name}}</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">@lang('app.branch_address')</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">{{$payment->branch_address}}</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">@lang('app.account_name')</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">{{$payment->account_name}}</div>
                </div>  
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">@lang('app.iban')</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">{{$payment->iban}}</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">@lang('app.time')</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">{{$payment->created_at->format('F d, Y h:i a')}}</div>
                </div>                         
            @endif

            @if($payment->reward)
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">@lang('app.amount')</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">{!! get_amount($payment->reward->amount) !!}</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">@lang('app.description')</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">{{$payment->reward->description}}</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">@lang('app.estimated_delivery')</div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <div class="mb-2">{{$payment->reward->estimated_delivery}}</div>
                </div>
            @endif


            @if($user->is_admin())
                @if($payment->status != 'success')
                    <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                        <button class="button w-24 justify-center block bg-theme-1 text-white ml-2">
                            <a href="{{route('status_change', [$payment->id, 'success'] )}}">
                            @lang("app.approved")
                        </button>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>



@endsection
