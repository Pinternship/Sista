@extends('layouts.theme')

@section('content')
    <!-- bradcam_area  -->
    <div class="bradcam_area bradcam_bg_1">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text">
                        <h3 style="font-size: 56px;font-weight: 400;text-transform: capitalize;">{!! !empty($title) ? $title : 'JobFair' !!}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ bradcam_area  -->
    <div class="checkout-page bg-white py-5">

        @php
        $user= auth()->user();
        @endphp

        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="checkout-form pt-3 pb-5">

                        <form method="post">
                            @csrf

                        <p>{{$user->name}}</p>
                        <h4>Package: {{$package->package_name}}</h4>
                        <p>@lang('app.premium_job') : {{$package->premium_job}}</p>
                        <p class="text-success">@lang('app.price') : {!! get_amount($package->price) !!}</p>


                        <h4 class="my-5 text-muted">Choose your gateway</h4>

                        <div class="checkout-gateways-wrap">
                            <div class="checkout-gateway bg-light p-3 my-3">
                                <label>
                                    <input type="radio" name="gateway" value="paypal" checked="checked"> @lang('app.paypal')
                                </label>
                            </div>

                            <div class="checkout-gateway bg-light p-3 my-3">
                                <label>
                                    <input type="radio" name="gateway" value="stripe"> @lang('app.stripe')
                                </label>
                            </div>

                            <div class="checkout-gateway bg-light p-3 my-3">
                                <label>
                                    <input type="radio" name="gateway" value="bank_transfer"> @lang('app.bank_transfer')
                                </label>
                            </div>
                        </div>

                            <button class="btn btn-success btn-lg"><i class="la la-cart-arrow-down"></i> @lang('app.checkout')</button>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection