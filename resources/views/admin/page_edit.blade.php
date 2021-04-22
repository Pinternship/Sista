@extends('layouts.dashboard')

@section('content')
<div class="intro-y box sm:py-20 mt-5">
    <form method="post" action="">
        @csrf
        <div class="px-5 sm:px-20">
            <div class="font-medium text-base">@lang('app.edit_page')</div>
            <div class="gap-4 mt-5">
                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('title')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.title') <font color="red">*</font></div>
                    <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('title', $errors)}}" id="title" value="{{$page->title}}" name="title" placeholder="@lang('app.title')" required>
                    <p style="color: #ff0000">{!! e_form_error('title', $errors) !!}
                </div>

                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('post_content')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.content') <font color="red">*</font></div>
                    <textarea name="post_content" id="post_content" class="form-control {{e_form_invalid_class('post_content', $errors)}}" rows="8">{{$page->post_content}}</textarea>
                    {!! e_form_error('post_content', $errors) !!}
                </div>

                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('show_in_header_menu')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.show_in_header_menu')</div>
                        <input type="checkbox" class="input border mr-2" name="show_in_header_menu" value="1" {{checked(1, $page->show_in_header_menu)}}> @lang('app.yes')
                        {!! e_form_error('show_in_header_menu', $errors) !!}
                        <div class="one">
                            <p class="text-info"> @lang('app.show_in_footer_menu')</p>
                        </div>
                </div>

               <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('show_in_footer_menu')? 'has-error':'' }}">
                    <div class="mb-2">@lang('app.show_in_footer_menu')</div>
                        <input type="checkbox" class="input border mr-2" name="show_in_footer_menu" value="1" {{checked(1, $page->show_in_footer_menu)}}> @lang('app.yes')
                        {!! e_form_error('show_in_footer_menu', $errors) !!}
                        <div class="one">
                            <p class="text-info"> @lang('app.show_in_footer_menu')</p>
                        </div>
                </div>                

                <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                    <button type="submit" class="button w-40 justify-center block bg-theme-1 text-white">@lang('app.edit')</button>
                </div>
            </div>
        </div>
    </form>
</div>


@endsection


@section('page-js')
    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}" defer></script>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace( 'post_content' );
        });
    </script>
@endsection