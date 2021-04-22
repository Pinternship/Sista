@extends('layouts.dashboard')

@section('content')
<div class="intro-y box sm:py-20 mt-5">
    <form method="post" action="">
        @csrf
        <div class="px-5 sm:px-20">
            <div class="font-medium text-base">@lang('app.edit')</div>
            <div class="gap-4 mt-5">
                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('category_name')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.category_name') <font color="red">*</font></div>
                    <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('category_name', $errors)}}" id="category_name" value="{{ $category->category_name }}" name="category_name" placeholder="@lang('app.category_name')" required>
                    <p style="color: #ff0000">{!! e_form_error('category_name', $errors) !!}
                </div>
                <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                    <button type="submit" class="button w-40 justify-center block bg-theme-1 text-white">@lang('app.edit')</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
