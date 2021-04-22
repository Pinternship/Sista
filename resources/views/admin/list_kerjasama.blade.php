@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h5>{{ date('d F Y') }}</h5>
        </div>
        <div class="col-md-12">
            <p>
                <a href="{{route('add_list_perusahaan')}}" target="_blank" class="btn btn-success c-link c-link--gray c-tooltip" aria-label="@lang('app.tambah')"><i class="la la-plus"></i> @lang('app.tambah')</a>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if($listperusahaans->count())
                <table class="table table-bordered">

                    <tr>
                        <th>@lang('app.no')</th>
                        <th>@lang('app.perusahaan')</th>
                        <th>@lang('app.kerjasama')</th>
                        <th>@lang('app.periode')</th>
                        <th>@lang('app.status_pembayaran')</th>
                        <th>@lang('app.status')</th>
                        <th>@lang('app.action')</th>
                    </tr>
                    @foreach($listperusahaans as $key => $application)
                        <tr>
                            <td>
                                {{ $listperusahaans->firstItem() + $key }}
                            </td>
                            <td>
                                <p>{{$application->company_name}}</p>
                            </td>
                            <td>
                                <p>{{$application->kerjasama}}</p>
                            </td>
                            <td>
                                {{-- {!! $application->periode !!} --}}
                                <p>{{$application->mulai_paket->format('F')}} - {{$application->akhir_paket->format('F')}}</p>
                            </td>
                            <td>
                                @if ($application->status == '1')
                                    <p>@lang('app.sudah_dibayar')</p>
                                @else
                                    <p>@lang('app.belum_dibayar')</p>
                                @endif
                            </td>
                            <td>
                                @php
                                    $bulan_sekarang = date('m');
                                    $tahun_sekarang = date('Y');
                                @endphp
                                @if ($application->status == "1")
                                    @if ($application->kerjasama == '3')
                                        @if (in_array($application->mulai_paket->format('m'), $paket1))
                                            @if ((in_array($bulan_sekarang, $paket1)) and ($tahun_sekarang == $application->mulai_paket->format('Y')))
                                                <p class="btn btn-success btn-sm">@lang('app.aktif')<p/>
                                            @else
                                                <p class="btn btn-danger btn-sm">@lang('app.nonaktif')<p/>
                                            @endif
                                        @elseif (in_array($application->mulai_paket->format('m'), $paket2))
                                            @if ($application->mulai_paket->format('m') == 12)
                                                @if ((in_array($bulan_sekarang, $paket2)) and ($tahun_sekarang <= $application->mulai_paket->format('Y')+1))
                                                    <p class="btn btn-success btn-sm">@lang('app.aktif')<p/>
                                                @else
                                                    <p class="btn btn-danger btn-sm">@lang('app.nonaktif')<p/>
                                                @endif
                                            @else
                                                @if ((in_array($bulan_sekarang, $paket2)) and ($tahun_sekarang == $application->mulai_paket->format('Y')))
                                                    <p class="btn btn-success btn-sm">@lang('app.aktif')<p/>
                                                @else
                                                    <p class="btn btn-danger btn-sm">@lang('app.nonaktif')<p/>
                                                @endif
                                            @endif
                                        @elseif (in_array($application->mulai_paket->format('m'), $paket3))
                                            @if ((in_array($bulan_sekarang, $paket3)) and ($tahun_sekarang == $application->mulai_paket->format('Y')))
                                                <p class="btn btn-success btn-sm">@lang('app.aktif')<p/>
                                            @else
                                                <p class="btn btn-danger btn-sm">@lang('app.nonaktif')<p/>
                                            @endif
                                        @elseif (in_array($application->mulai_paket->format('m'), $paket4))
                                            @if ((in_array($bulan_sekarang, $paket4)) and ($tahun_sekarang == $application->mulai_paket->format('Y')))
                                                <p class="btn btn-success btn-sm">@lang('app.aktif')<p/>
                                            @else
                                                <p class="btn btn-danger btn-sm">@lang('app.nonaktif')<p/>
                                            @endif
                                        @endif
                                    @elseif ($application->kerjasama == '6')
                                        @if (in_array($application->mulai_paket->format('m'), $paket1))
                                            @if (((in_array($bulan_sekarang, $paket1)) or (in_array($bulan_sekarang, $paket2))) and  ($tahun_sekarang == $application->mulai_paket->format('Y')))
                                                <p class="btn btn-success btn-sm">@lang('app.aktif')<p/>
                                            @else
                                                <p class="btn btn-danger btn-sm">@lang('app.nonaktif')<p/>
                                            @endif
                                        @elseif (in_array($application->mulai_paket->format('m'), $paket2))
                                            @if ($application->mulai_paket->format('m') == 12)
                                                @if(((in_array($bulan_sekarang, $paket1)) or (in_array($bulan_sekarang, $paket2))) and ($tahun_sekarang <= ($application->mulai_paket->format('Y')+1)))
                                                    <p class="btn btn-success btn-sm">@lang('app.aktif')<p/>
                                                @else
                                                    <p class="btn btn-danger btn-sm">@lang('app.nonaktif')<p/>
                                                @endif
                                            @else
                                                @if(((in_array($bulan_sekarang, $paket1)) or (in_array($bulan_sekarang, $paket2))) and ($tahun_sekarang == $application->mulai_paket->format('Y')))
                                                    <p class="btn btn-success btn-sm">@lang('app.aktif')<p/>
                                                @else
                                                    <p class="btn btn-danger btn-sm">@lang('app.nonaktif')<p/>
                                                @endif
                                            @endif
                                        @elseif (in_array($application->mulai_paket->format('m'), $paket3))
                                            @if(((in_array($bulan_sekarang, $paket3)) or (in_array($bulan_sekarang, $paket4))) and ($tahun_sekarang == $application->mulai_paket->format('Y')))
                                                <p class="btn btn-success btn-sm">@lang('app.aktif')<p/>
                                            @else
                                                <p class="btn btn-danger btn-sm">@lang('app.nonaktif')<p/>
                                            @endif
                                        @elseif (in_array($application->mulai_paket->format('m'), $paket4))
                                            @if(((in_array($bulan_sekarang, $paket3)) or (in_array($bulan_sekarang, $paket4))) and ($tahun_sekarang == $application->mulai_paket->format('Y')))
                                                <p class="btn btn-success btn-sm">@lang('app.aktif')<p/>
                                            @else
                                                <p class="btn btn-danger btn-sm">@lang('app.nonaktif')<p/>
                                            @endif
                                        @endif
                                    @elseif ($application->kerjasama == '12')
                                        @if ((in_array($application->mulai_paket->format('m'), $bulan_paketawal)) and ($application->mulai_paket->format('Y') == $tahun_sekarang))
                                            <p class="btn btn-success btn-sm">@lang('app.aktif')<p/>
                                        @elseif (in_array($application->mulai_paket->format('m'), $bulan_paketakhir) and ($tahun_sekarang <= ($application->mulai_paket->format('Y')+1)))
                                            <p class="btn btn-success btn-sm">@lang('app.aktif')<p/>
                                        @else
                                            <p class="btn btn-danger btn-sm">@lang('app.nonaktif')<p/>
                                        @endif
                                    @endif
                                @else
                                    <p class="btn btn-danger btn-sm">@lang('app.nonaktif')<p/>
                                @endif

                            </td>
                            <td>
                                <p><a href="{{route('list_perusahaan_delete', $application->id)}}" target="_blank" class="btn btn-success btn-sm c-link c-link--gray c-tooltip" aria-label="@lang('app.print')"><i class="la la-print"></i> </a>
                                <a href="{{route('list_perusahaan_edit', $application->id)}}" target="_blank" class="btn btn-warning btn-sm c-link c-link--gray c-tooltip" aria-label="@lang('app.edit')"><i class="la la-edit"></i> </a>
                                <a href="{{route('list_perusahaan_delete', $application->id)}}" target="_blank" class="btn btn-danger btn-sm c-link c-link--gray c-tooltip" aria-label="@lang('app.delete')"><i class="la la-trash-o"></i> </a></p>
                            </td>

                        </tr>
                    @endforeach

                </table>

                {!! $listperusahaans->links() !!}
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
    </div>



@endsection
