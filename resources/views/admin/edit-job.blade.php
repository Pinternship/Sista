@extends('layouts.dashboard')
@section('content')
        <div class="intro-y box sm:py-20 mt-5">
            <form method="post" action="">
                @csrf
                <div class="px-5 sm:px-20">
                    <div class="font-medium text-base">@lang('app.edit')</div>
                        <div class="gap-4 mt-5">

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('job_title')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.job_title') <font color="red">*</font></div>
                                <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('job_title', $errors)}}" id="job_title" value="{{ $job->job_title }}" name="job_title" placeholder="@lang('app.job_title')" required>
                                <p style="color: #ff0000">{!! e_form_error('job_title', $errors) !!}
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('position')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.position') <font color="red">*</font></div>
                                <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('position', $errors)}}" id="position" value="{{$job->position}}" name="position" placeholder="@lang('app.position')" required>
                                {!! e_form_error('job_title', $errors) !!}
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('category')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.select_category') <font color="red">*</font></div>
                                <select class="input w-full border flex-1 {{e_form_invalid_class('category', $errors)}}" name="category" id="category" required>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{selected($category->id, $job->category_id)}} >{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                                {!! e_form_error('category', $errors) !!}
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('salary_cycle')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.salary_cycle')</div>
                                <select class="input w-full border flex-1 {{e_form_invalid_class('salary_cycle', $errors)}}" name="salary_cycle" id="salary_cycle">
                                    <option value="monthly"  {{selected('monthly', $job->salary_cycle)}}>@lang('app.monthly')</option>
                                    <option value="yearly" {{selected('yearly', $job->salary_cycle)}}>@lang('app.yearly')</option>
                                    <option value="weekly" {{selected('weekly', $job->salary_cycle)}}>@lang('app.weekly')</option>
                                </select>
                                {!! e_form_error('salary_cycle', $errors) !!}
                            </div>

                            <div class="grid grid-cols-12 gap-6 mb-5">
                                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('salary')? 'has-error':'' }}">
                                    <div class="mb-2">@lang('app.salary')</div>
                                    <input type="number" class="input w-full border flex-1 {{e_form_invalid_class('salary', $errors)}}" id="salary" value="{{ $job->salary }}" name="salary" placeholder="@lang('app.salary')">
                                    {!! e_form_error('salary', $errors) !!}
                                </div>


                                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('is_negotiable')? 'has-error':'' }}">
                                    <div class="mb-2">@lang('app.is_negotiable')</div>
                                    <select class="input w-full border flex-1 {{e_form_invalid_class('is_negotiable', $errors)}}" name="is_negotiable" id="is_negotiable">
                                        <option value="1"  {{selected('1', $job->is_negotiable)}}>@lang('app.yes')</option>
                                        <option value="0"  {{selected('0', $job->is_negotiable)}}>@lang('app.no')</option>
                                    </select>
                                    {!! e_form_error('is_negotiable', $errors) !!}
                                </div>
                            </div>


                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('vacancy')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.vacancy')</div>
                                    <input type="number" class="input w-full border flex-1 {{e_form_invalid_class('vacancy', $errors)}}" id="vacancy" value="{{$job->vacancy}}" name="vacancy" placeholder="@lang('app.vacancy')">
                                    {!! e_form_error('vacancy', $errors) !!}
                                </div>
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('gender')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.gender')</div>
                                    <select class="input w-full border flex-1 {{e_form_invalid_class('gender', $errors)}}" name="gender" id="gender">
                                        <option value="any"  {{selected('any', $job->gender)}}>@lang('app.any')</option>
                                        <option value="male"  {{selected('male', $job->gender)}}>@lang('app.male')</option>
                                        <option value="female"  {{selected('female', $job->gender)}}>@lang('app.female')</option>
                                    </select>
                                    {!! e_form_error('gender', $errors) !!}
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('job_type')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.job_type')</div>
                                    <select class="input w-full border flex-1 {{e_form_invalid_class('job_type', $errors)}}" name="job_type" id="job_type">
                                        <option value="internship"  {{selected('internship', $job->job_type)}}>@lang('app.internship')</option>
                                        <option value="internship+skripsi"  {{selected('internship+skripsi', $job->job_type)}}>@lang('app.internship+skripsi')</option>
                                        <option value="internship+skripsi+pegawai"  {{selected('internship+skripsi+pegawai', $job->job_type)}}>@lang('app.internship+skripsi+pegawai')</option>

                                        {{-- <option value="full_time" {{ old('job_type') == 'full_time' ? 'selected':'' }}>@lang('app.full_time')</option> --}}
                                        {{-- <option value="part_time" {{ old('job_type') == 'part_time' ? 'selected':'' }}>@lang('app.part_time')</option> --}}
                                        {{-- <option value="contract" {{ old('job_type') == 'contract' ? 'selected':'' }}>@lang('app.contract')</option>
                                        <option value="temporary" {{ old('job_type') == 'temporary' ? 'selected':'' }}>@lang('app.temporary')</option>
                                        <option value="commission" {{ old('job_type') == 'commission' ? 'selected':'' }}>@lang('app.commission')</option> --}}
                                    </select>
                                    {!! e_form_error('job_type', $errors) !!}
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('job_duration')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.job_duration') <font color="red"> *</font></div>
                                    <div class="relative mt-2">
                                        <input type="number" class="input w-full border flex-1 {{e_form_invalid_class('job_duration', $errors)}}" id="job_duration" value="{{$job->job_duration}}" name="job_duration" placeholder="@lang('app.job_duration')" required>
                                        <div class="absolute top-0 right-0 rounded-r w-16 h-full flex items-center justify-center bg-gray-100 border text-gray-600">@lang('app.month')</div>
                                        {!! e_form_error('job_duration', $errors) !!}
                                    </div>
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('deadline')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.deadline')</div>
                                    <div class="relative">
                                        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-gray-100 border text-gray-600">
                                            <i data-feather="calendar" class="w-4 h-4"></i>
                                        </div>
                                        <input type="text" class="deadline input pl-12 w-full border flex-1 {{e_form_invalid_class('deadline', $errors)}}" id="deadline" value="{{$job->deadline->format('m-d-Y')}}" name="deadline" placeholder="@lang('app.deadline')">
                                        {!! e_form_error('deadline', $errors) !!}
                                    </div>
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('description')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.description')</div>
                                    <textarea name="description" class="input w-full border flex-1  {{e_form_invalid_class('description', $errors)}}" rows="5">{!! $job->description !!}</textarea>
                                    {!! $errors->has('description')? '<p class="help-block">'.$errors->first('description').'</p>':'' !!}
                                    <p class="text-info"> @lang('app.description_info_text')</p>
                            </div>


                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('skills')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.skills')</div>
                                    <textarea name="skills" class="input w-full border flex-1 {{e_form_invalid_class('skills', $errors)}}" rows="2" placeholder="FlowChart, Design">{!! $job->skills !!}</textarea>
                                    {!! $errors->has('skills')? '<p class="help-block">'.$errors->first('skills').'</p>':'' !!}
                                    <p class="text-info"> @lang('app.skills_info_text')</p>
                            </div>


                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('responsibilities')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.responsibilities')</div>
                                    <textarea name="responsibilities" class="input w-full border flex-1 {{e_form_invalid_class('responsibilities', $errors)}}" rows="3">{!! $job->responsibilities !!}</textarea>
                                    {!! $errors->has('responsibilities')? '<p class="help-block">'.$errors->first('responsibilities').'</p>':'' !!}
                                    <p class="text-info"> @lang('app.responsibilities_info_text')</p>
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('educational_requirements')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.educational_requirements')</div>
                                    <textarea name="educational_requirements" class="input w-full border flex-1 {{e_form_invalid_class('educational_requirements', $errors)}}" rows="3" placeholder="S1 Sistem Informasi&#10;S1 DKV&#10;S1 Akuntasi">{!! $job->educational_requirements !!}</textarea>
                                    {!! $errors->has('educational_requirements')? '<p class="help-block">'.$errors->first('educational_requirements').'</p>':'' !!}
                                    <p class="text-info"> @lang('app.educational_requirements_info_text')</p>
                            </div>

                            <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('benefits')? 'has-error':'' }}">
                                <div class="mb-2">@lang('app.benefits')</div>
                                    <textarea name="benefits" class="input w-full border flex-1 {{e_form_invalid_class('benefits', $errors)}}" rows="3">{!! $job->benefits !!}</textarea>
                                    {!! $errors->has('benefits')? '<p class="help-block">'.$errors->first('benefits').'</p>':'' !!}
                                    <p class="text-info"> @lang('app.benefits_info_text')</p>
                            </div>


                            @if($job->is_any_where == 1)
                                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('is_any_where')? 'has-error':'' }}">
                                    <div class="ex3">
                                        <div class="mb-2">@lang('app.is_any_where')</div>
                                            <input type="checkbox" class="one-box input border mr-2" name="is_any_where" value="1" onchange="hideMe('div2')" {{checked('1', $job->is_any_where)}} > @lang('app.yes')
                                            {!! e_form_error('is_any_where', $errors) !!}
                                        </div>
                                </div>

                                <div id="div2" style="display:none;">
                                    <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('country')? 'has-error':'' }}">
                                        <div class="mb-2">@lang('app.country')</div>
                                            <select name="country" class="input w-full border flex-1 {{e_form_invalid_class('country', $errors)}} country_options">
                                                <option value="">Select a state</option>
                                                @foreach($countries as $country)
                                                     <option value="{!! $country->id !!}" {{selected($country->id, $job->country_id)}}  >{!! $country->country_name !!}</option>
                                                @endforeach
                                            </select>
                                            {!! e_form_error('country', $errors) !!}
                                    </div>


                                    <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('state')? 'has-error':'' }}">
                                        <div class="mb-2">@lang('app.state')</div>
                                            <select name="state" class="input w-full border flex-1 {{e_form_invalid_class('state', $errors)}} state_options">
                                                <option value="">Select a state</option>
                                                @if($old_country)
                                                    @foreach($old_country->states as $state)
                                                        <option value="{{$state->id}}" {{selected($state->id, $job->state_id)}}>{!! $state->state_name !!}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            {!! e_form_error('state', $errors) !!}
                                    </div>

                                    <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('city_name')? 'has-error':'' }}">
                                        <div class="mb-2">@lang('app.city_name')</div>
                                        <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('city_name', $errors)}}" id="city_name" value="{{$job->city_name}}" name="city_name" placeholder="@lang('app.city_name')">
                                        {!! e_form_error('city_name', $errors) !!}
                                    </div>
                                </div>
                            @else
                                <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('is_any_where')? 'has-error':'' }}">
                                    <div class="ex3">
                                        <div class="mb-2">@lang('app.is_any_where')</div>
                                            <input type="checkbox" class="two-box input border mr-2" name="is_any_where" value="1" onchange="hideMe('div2')" {{checked('1', $job->is_any_where)}} > @lang('app.yes')
                                            {!! e_form_error('is_any_where', $errors) !!}
                                        </div>
                                </div>

                                <div id="div2">
                                    <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('country')? 'has-error':'' }}">
                                        <div class="mb-2">@lang('app.country')</div>
                                            <select name="country" class="input w-full border flex-1 {{e_form_invalid_class('country', $errors)}} country_options">
                                                <option value="">Select a state</option>
                                                @foreach($countries as $country)
                                                     <option value="{!! $country->id !!}" {{selected($country->id, $job->country_id)}}  >{!! $country->country_name !!}</option>
                                                @endforeach
                                            </select>
                                            {!! e_form_error('country', $errors) !!}
                                    </div>


                                    <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('state')? 'has-error':'' }}">
                                        <div class="mb-2">@lang('app.state')</div>
                                            <select name="state" class="input w-full border flex-1 {{e_form_invalid_class('state', $errors)}} state_options">
                                                <option value="">Select a state</option>
                                                @if($old_country)
                                                    @foreach($old_country->states as $state)
                                                        <option value="{{$state->id}}" {{selected($state->id, $job->state_id)}}>{!! $state->state_name !!}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            {!! e_form_error('state', $errors) !!}
                                    </div>

                                    <div class="intro-y col-span-12 sm:col-span-6 mb-5 {{ $errors->has('city_name')? 'has-error':'' }}">
                                        <div class="mb-2">@lang('app.city_name')</div>
                                        <input type="text" class="input w-full border flex-1 {{e_form_invalid_class('city_name', $errors)}}" id="city_name" value="{{$job->city_name}}" name="city_name" placeholder="@lang('app.city_name')">
                                        {!! e_form_error('city_name', $errors) !!}
                                    </div>
                                </div>
                            @endif

                            <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                                <button type="submit" class="button w-40 justify-center block bg-theme-1 text-white">@lang('app.edit_job')</button>
                            </div>
                    </div>
                </div>
            </form>
        </div>



@endsection


@section('page-js')

@endsection

@section('scripts')
<script type="text/javascript">
    const picker = new Litepicker({
        element: document.getElementById('deadline'),
        autoApply: true,
        singleMode: true,
        numberOfColumns: 1,
        numberOfMonths: 1,
        showWeekNumbers: false,
        mobileFriendly: true,
        format: 'YYYY-MM-DD',
        minDate: new Date(),
        dropdowns: {
            minYear: (new Date()).getFullYear(),
            maxYear: (new Date()).getFullYear()+5,
            months: true,
            years: true
        }
    });
</script>
@endsection
