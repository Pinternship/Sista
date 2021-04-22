@extends('layouts.dashboard')

@section('content')
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
        <button class="button text-white bg-theme-1 shadow-md mr-2">
            <a href="{{route('add_post')}}">
                @lang('app.add_post')
            </a>
        </button>
        <div class="hidden md:block mx-auto text-gray-600"> - </div>
        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <form class="form-inline" method="get" action="">
            <div class="w-56 relative text-gray-700">
                <input type="text" name="q" value="{{request('q')}}" class="input w-56 box pr-10 placeholder-theme-13" placeholder="@lang('app.title')">
                <button type="submit" class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></button>
            </div>
             </form>
        </div>
    </div>

    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        @if($posts->count())
        <table class="table table-report -mt-2">
            <thead>
                <tr>
                    <th>@lang('app.title')</th>
                    <th>@lang('app.thumb')</th>
                    <th>#</th>
                </tr>                    
            </thead>
            @foreach($posts as $post)
            <tbody>
                <tr>
                    <td>{{$post->title}}</td>
                    <td>
                        <div class="image-zoom">
                            <img alt="" class="img-fluid" style="max-width: 100px;" src="{{$post->feature_image_thumb_uri}}" data-zoom="{{$post->feature_image_thumb_uri}}">
                        </div>
                    </td>
                    <td>
                         <button class="tooltip button px-2 mr-1 mb-2 bg-theme-1 text-white" title="@lang("app.edit")">
                            <a href="{{route('post_edit', $post->id)}}">
                            <span class="w-5 h-5 flex items-center justify-center">
                                <i class="fal fa-edit w-4 h-4"></i>
                            </span>
                            </a>
                        </button>

                        <button class="tooltip button px-2 mr-1 mb-2 bg-theme-6 text-white" title="@lang("app.delete")">
                            <a href="{{route('post_delete', [$post->id, 'delete'])}}">
                            <span class="w-5 h-5 flex items-center justify-center">
                                <i class="fal fa-trash-alt w-4 h-4"></i>
                            </span>
                            </a>
                        </button>                        
                    </td>
                </tr>                
            </tbody>
            @endforeach
        </table>
        @endif
        {!! $posts->links('vendor.pagination.tailwind') !!}
    </div>
</div>
@endsection