@extends('layouts.dashboard')

@section('content')
<div class="intro-y box sm:py-20 mt-5">
     <form method="post" action="" enctype="multipart/form-data">
        @csrf
        <div class="px-5 sm:px-20">
            <div class="font-medium text-base">@lang('app.general_settings')</div>
            <div class="gap-4 mt-5">

                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('site_name')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.site_name') </div>
                    <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('site_name', $errors)}}" id="site_name" value="{{ old('site_name')? old('site_name') : get_option('site_name') }}" name="site_name" placeholder="@lang('app.site_name')">
                    <p style="color: #ff0000">{!! e_form_error('site_name', $errors) !!}
                </div>

                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('site_title')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.site_title') </div>
                    <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('site_title', $errors)}}" id="site_title" value="{{ old('site_title')? old('site_title') : get_option('site_title') }}" name="site_title" placeholder="@lang('app.site_title')">
                    {!! e_form_error('job_title', $errors) !!}
                </div>


                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('email_address')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.email_address') </div>
                    <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('email_address', $errors)}}" id="email_address" value="{{ old('email_address')? old('email_address') : get_option('email_address') }}" name="email_address" placeholder="@lang('app.email_address')">
                    {!! e_form_error('job_title', $errors) !!}
                </div>

                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('default_timezone')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.default_timezone') <font color="red">*</font></div>
                    <select class="input w-full border flex-1 {{e_form_invalid_class('default_timezone', $errors)}}" name="default_timezone" id="default_timezone" required>
                        @php $saved_timezone = get_option('default_timezone'); @endphp
                        @foreach(timezone_identifiers_list() as $key=>$value)
                            <option value="{{ $value }}" {{ $saved_timezone == $value? 'selected':'' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    {!! e_form_error('default_timezone', $errors) !!}
                    <p class="text-info">@lang('app.default_timezone_help_text')</p>
                </div>

                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('date_format')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.date_format')</div>
                            <fieldset>
                                @php $saved_date_format = get_option('date_format'); @endphp

                                <label><input type="radio" value="F j, Y" name="date_format" {{ $saved_date_format == 'F j, Y'? 'checked':'' }}> {{ date('F j, Y') }}<code>F j, Y</code></label> <br />
                                <label><input type="radio" value="Y-m-d" name="date_format" {{ $saved_date_format == 'Y-m-d'? 'checked':'' }}> {{ date('Y-m-d') }}<code>Y-m-d</code></label> <br />

                                <label><input type="radio" value="m/d/Y" name="date_format" {{ $saved_date_format == 'm/d/Y'? 'checked':'' }}> {{ date('m/d/Y') }}<code>m/d/Y</code></label> <br />

                                <label><input type="radio" value="d/m/Y" name="date_format" {{ $saved_date_format == 'd/m/Y'? 'checked':'' }}> {{ date('d/m/Y') }}<code>d/m/Y</code></label> <br />

                                <label><input type="radio" value="custom" name="date_format" {{ $saved_date_format == 'custom'? 'checked':'' }}> Custom:</label>
                                <input type="text" value="{{ get_option('date_format_custom') }}" id="date_format_custom" name="date_format_custom" />
                                <span>example: {{ date(get_option('date_format_custom')) }}</span>
                            </fieldset>
                    {!! e_form_error('date_format', $errors) !!}
                    <p class="text-info"> @lang('app.date_format_help_text')</p>
                </div> 

                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('time_format')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.time_format')</div>
                            <fieldset>
                                <label><input type="radio" value="g:i a" name="time_format" {{ get_option('time_format') == 'g:i a'? 'checked':'' }}> {{ date('g:i a') }}<code>g:i a</code></label> <br />
                                <label><input type="radio" value="g:i A" name="time_format" {{ get_option('time_format') == 'g:i A'? 'checked':'' }}> {{ date('g:i A') }}<code>g:i A</code></label> <br />

                                <label><input type="radio" value="H:i" name="time_format" {{ get_option('time_format') == 'H:i'? 'checked':'' }}> {{ date('H:i') }}<code>H:i</code></label> <br />

                                <label><input type="radio" value="custom" name="time_format" {{ get_option('time_format') == 'custom'? 'checked':'' }}> Custom:</label>
                                <input type="text" value="{{ get_option('time_format_custom') }}" id="time_format_custom" name="time_format_custom" />
                                <span>example: {{ date(get_option('time_format_custom')) }}</span>
                            </fieldset>
                    {!! e_form_error('time_format', $errors) !!}
                    <p><a href="http://php.net/manual/en/function.date.php" target="_blank">@lang('app.date_time_read_more')</a> </p>
                </div> 

                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('currency_sign')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.currency_sign') <font color="red">*</font></div>
                    <?php $current_currency = get_option('currency_sign'); ?>
                    <select class="input w-full border flex-1 {{e_form_invalid_class('currency_sign', $errors)}}" name="currency_sign" id="currency_sign" required>
                        @foreach(get_currencies() as $code => $name)
                            <option value="{{ $code }}"  {{ $current_currency == $code? 'selected':'' }}> {{ $code }} </option>
                        @endforeach
                    </select>
                    {!! e_form_error('currency_sign', $errors) !!}
                    <p class="text-info">@lang('app.default_timezone_help_text')</p>
                </div>

                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('currency_position')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.currency_position') <font color="red">*</font></div>
                    <?php $currency_position = get_option('currency_position'); ?>
                    <select class="input w-full border flex-1 {{e_form_invalid_class('currency_position', $errors)}}" name="currency_position" id="currency_position" required>
                        <option value="left" @if($currency_position == 'left') selected="selected" @endif >@lang('app.left')</option>
                        <option value="right" @if($currency_position == 'right') selected="selected" @endif >@lang('app.right')</option>
                    </select>
                    {!! e_form_error('currency_position', $errors) !!}
                    <p class="text-info">@lang('app.default_timezone_help_text')</p>
                </div>

                <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                    <button type="submit" class="button w-40 justify-center block bg-theme-1 text-white">@lang('app.save_settings')</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection