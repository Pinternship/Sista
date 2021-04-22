@extends('layouts.dashboard')


@section('page-css')
    <link href="{{asset('assets/plugins/bootstrap-datepicker-1.6.4/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10">

            <form method="post" action="">
                @csrf

                <div class="form-group row">
                    <label class="col-sm-4 control-label">@lang('app.nama_perusahaan') <font color="red">*</font> </label>
                    <div class="col-sm-8">
                        <input type="namaperusahaan" class="form-control" id="namaperusahaan" value="{{$report->company_name}}" name="namaperusahaan">
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('mulai_paket')? 'has-error':'' }}">
                    <label for="mulai_paket" class="col-sm-4 control-label"> @lang('app.mulai_paket') <font color="red">*</font></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control {{e_form_invalid_class('mulai_paket', $errors)}} date_picker" id="mulai_paket" value="{{$report->mulai_paket}}" name="mulai_paket" placeholder="@lang('app.mulai_paket')">
                        <p class="text-info"> @lang('app.periksa_kembali')</p>
                        {!! e_form_error('mulai_paket', $errors) !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('akhir_paket')? 'has-error':'' }}">
                    <label for="akhir_paket" class="col-sm-4 control-label"> @lang('app.akhir_paket') <font color="red">*</font></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control {{e_form_invalid_class('akhir_paket', $errors)}} date_picker" id="akhir_paket" value="{{$report->akhir_paket}}" name="akhir_paket" placeholder="@lang('app.akhir_paket')">
                        <p class="text-info"> @lang('app.periksa_kembali')</p>
                        {!! e_form_error('akhir_paket', $errors) !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('kerjasama')? 'has-error':'' }}">
                    <label for="kerjasama" class="col-sm-4 control-label">@lang('app.kerjasama') <font color="red">*</font></label>
                    <div class="col-sm-8">

                        <div class="price_input_group">
                            <select class="form-control {{e_form_invalid_class('kerjasama', $errors)}}" name="kerjasama" value="{{$report->kerjasama}}">
                                <option value="3"  {{selected('3', $report->kerjasama)}}>3</option>
                                <option value="6" {{selected('6', $report->kerjasama)}}>6</option>
                                <option value="12" {{selected('12', $report->kerjasama)}}>12</option>
                            </select>

                            {!! e_form_error('kerjasama', $errors) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 control-label"> @lang('app.pembayaran') <font color="red">*</font></label>
                    <div class="col-sm-8">
                        <input type="pembayaran" class="form-control" id="pembayaran" value="{{$report->pembayaran}}" name="pembayaran">
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('status_pembayaran')? 'has-error':'' }}">
                    <label for="status_pembayaran" class="col-sm-4 control-label">@lang('app.status_pembayaran') <font color="red">*</font></label>
                    <div class="col-sm-8">

                        <div class="price_input_group">

                            <select class="form-control {{e_form_invalid_class('status_pembayaran', $errors)}}" name="status_pembayaran">
                                <option value="1"  {{selected('1', $report->status)}}>@lang('app.sudah_dibayar')</option>
                                <option value="0" {{selected('0', $report->status)}}>@lang('app.belum_dibayar')</option>
                            </select>

                            {!! e_form_error('status_pembayaran', $errors) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4"></label>
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-primary">@lang('app.edit')</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('page-js')
<script src="{{asset('assets/plugins/bootstrap-datepicker-1.6.4/js/bootstrap-datepicker.js')}}"></script>
@endsection
