@extends('layouts.dashboard')

@section('content')
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
    
    <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
        <div class="w-56 relative text-gray-700">
            <form method="post" action="">
                @csrf
                <div class="w-56 relative text-gray-700 {{ $errors->has('category_name')? 'has-error':'' }}">
                    <input type="text" class="input w-56 box pr-10 placeholder-theme-13 {{e_form_invalid_class('category_name', $errors)}}" id="category_name" value="{{ old('category_name') }}" name="category_name" placeholder="@lang('app.category_name')">
                    {!! e_form_error('category_name', $errors) !!}
                    <button type="submit" class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="plus"></button>
                </div>
             </form>
        </div>
    </div>


    <div class="hidden md:block mx-auto text-gray-600"> - </div>
    <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
        <div class="w-56 relative text-gray-700">
            <form class="form-inline" method="get" action="">
                <div class="w-56 relative text-gray-700">
                    <input type="text" name="q" value="{{request('q')}}" class="input w-56 box pr-10 placeholder-theme-13" placeholder="@lang('app.name')">
                    <button type="submit" class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></button>
                </div>
             </form>
        </div>
    </div>
    </div>

    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
            <thead>
                <tr>
                    <th>@lang('app.category_name')</th>
                    <th>@lang('app.action')</th>
                </tr>
            </thead>
            @foreach($categories as $category)
            <tbody>
                <tr>
                    <td>
                        {{ $category->category_name }}
                    </td>
                    <td>
                        <button class="tooltip button px-2 mr-1 mb-2 bg-theme-3 text-white" title="@lang("app.edit")">
                            <a href="{{ route('edit_categories', $category->id) }}" target="_blank">
                            <span class="w-5 h-5 flex items-center justify-center">
                                <i class="fal fa-pencil w-4 h-4"></i>
                            </span>
                            </a>
                        </button>
                        <button class="tooltip button px-2 mr-1 mb-2 bg-theme-6 text-white" title="@lang("app.delete")">
                            <a href="{{route('category_delete', [$category->id, 'delete'])}}">
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
    </div>

</div>



@endsection