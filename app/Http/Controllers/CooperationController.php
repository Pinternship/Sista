<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\JobFinalReport;
use App\Models\JobMonthlyReport;
use App\Models\JobApplication;
use App\Models\State;
use App\Models\Job;

use App\Models\User;
use App\Models\Cooperation;
use App\Models\Pacakge;

use DataTables;
use PDF;
use DateTime;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Illuminate\Support\Facades\Mail;
use App\Mail\AcceptMail;

use Kyslik\ColumnSortable\Sortable;

class CooperationController extends Controller
{

    /**
     * @param $id
     * @param null $status
     * @return \Illuminate\Http\RedirectResponse
     */

    public $sortable = ['job_id'];

    // Monthly Report
    public function ListPerusahaan(){
        $title = __('app.list_perusahaan');
        $employer_id = Auth::user()->id;
        $user = Auth::user();


        $listperusahaans = Cooperation::orderBy('id', 'desc')->paginate(5);

        // Paket
        $paket1 = array(9,10,11);
        $paket2 = array(12,1,2);
        $paket3 = array(3,4,5);
        $paket4 = array(6,7,8);

        // Bulan
        $bulan_paketawal = array(9,10,11,12);
        $bulan_paketakhir = array(1,2,3,4,5,6,7,8);
        return view('admin.list_kerjasama', compact('title', 'listperusahaans', 'paket1', 'paket2', 'paket3', 'paket4', 'bulan_paketawal', 'bulan_paketakhir' ));
    }

    public function addListPerusahaan(){
        $title = __('app.add_list_perusahaan');
        $user = Auth::user();
        if($user->is_admin()) {
            return view('admin.add_kerjasama', compact('title'));
        }
        else{
            return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));
        }
    }

    public function postnewListPerusahaan(Request $request ){
        $user_id = Auth::user()->id;

        $rules = [
            'namaperusahaan'    =>  'required',
            'mulai_paket'       =>   'required',
            'akhir_paket'       =>   'required',
        ];
        $this->validate($request, $rules);

        // Bulan
        $dateFormat = 'Y-m-d';
        $stringDate = $request->mulai_paket;
        $date = DateTime::createFromFormat($dateFormat, $stringDate);
        $bulan =  $date->format('m');

        // Paket
        $paket1 = array(9,10,11);
        $paket2 = array(12,1,2);
        $paket3 = array(3,4,5);
        $paket4 = array(6,7,8);

        if ($request->kerjasama == 3) {
            if (in_array($bulan, $paket1)) {
                $periode="September - Oktober - November";
            } elseif (in_array($bulan, $paket2)) {
                $periode="Desember - Januari - Februari";
            } elseif (in_array($bulan, $paket3)) {
                $periode="Maret - April - Mei";
            } elseif (in_array($bulan, $paket4)) {
                $periode="Juni - Juli - Agustus";
            } else {
                $periode="Data tidak ditemukan";
            }
        }
        elseif ($request->kerjasama == 6) {
            if ((in_array($bulan, $paket1)) or (in_array($bulan, $paket2))) {
                $periode = "<p>September - Oktober - November</p><p>Desember - Januari - Februari</p>";
            } elseif((in_array($bulan, $paket3)) or (in_array($bulan, $paket4))) {
                $periode = "<p>Maret - April - Mei</p><p>Juni - Juli - Agustus</p>";
            } else{
                $periode="Data tidak ditemukan";
            }
        }
        elseif ($request->kerjasama == 12) {
            if ((in_array($bulan, $paket1)) or (in_array($bulan, $paket2))) {
                $periode = "<p>September - Oktober - November</p><p>Desember - Januari - Februari</p><p>Maret - April - Mei</p><p>Juni - Juli - Agustus</p>";
            } elseif((in_array($bulan, $paket3)) or (in_array($bulan, $paket4))) {
                $periode = "<p>September - Oktober - November</p><p>Desember - Januari - Februari</p><p>Maret - April - Mei</p><p>Juni - Juli - Agustus</p>";
            } else{
                $periode="Data tidak ditemukan";
            }
        } else{
            $periode="Data tidak ditemukan";
        }

        $company_slug = unique_slug($request->namaperusahaan, 'Cooperation', 'company_slug');
        $application_data = [
            'company_id'            => '01',
            'company_slug'          => $company_slug,
            'company_name'          => $request->namaperusahaan,
            'mulai_paket'           => $request->mulai_paket,
            'akhir_paket'           => $request->akhir_paket,
            'periode'               => $periode,
            'kerjasama'             => $request->kerjasama,
            'pembayaran'            => $request->pembayaran,
            'status'                => $request->status_pembayaran,
        ];


        $user = Auth::user();
        if($user->is_admin() ){
            $job = Cooperation::create($application_data);
            if ( ! $job){
                return back()->with('error', 'app.something_went_wrong')->withInput($request->input());
            }
            return back()->with('success', trans('app.cooperation_add_success_msg'));
        }else{
            return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));
        }
    }

    public function editListPerusahaan($id){
        $title = __('app.list_perusahaan_edit');
        $report = Cooperation::find($id);

        $user = Auth::user();
        return view('admin.edit_kerjasama', compact('title', 'report'));
    }

    public function posteditListPerusahaan(Request $request, $id){

        $report = Cooperation::find($id);
        $user_id = Auth::user()->id;

        $rules = [
            'namaperusahaan'    =>  'required',
            'mulai_paket'       =>   'required',
            'akhir_paket'       =>   'required',
        ];
        $this->validate($request, $rules);

        // Bulan
        $dateFormat = 'Y-m-d';
        $stringDate = $request->mulai_paket;
        $date = DateTime::createFromFormat($dateFormat, $stringDate);
        $bulan =  $date->format('m');

        // Paket
        $paket1 = array(9,10,11);
        $paket2 = array(12,1,2);
        $paket3 = array(3,4,5);
        $paket4 = array(6,7,8);

        if ($request->kerjasama == 3) {
            if (in_array($bulan, $paket1)) {
                $periode="September - Oktober - November";
            } elseif (in_array($bulan, $paket2)) {
                $periode="Desember - Januari - Februari";
            } elseif (in_array($bulan, $paket3)) {
                $periode="Maret - April - Mei";
            } elseif (in_array($bulan, $paket4)) {
                $periode="Juni - Juli - Agustus";
            } else {
                $periode="Data tidak ditemukan";
            }
        }
        elseif ($request->kerjasama == 6) {
            if ((in_array($bulan, $paket1)) or (in_array($bulan, $paket2))) {
                $periode = "<p>September - Oktober - November</p><p>Desember - Januari - Februari</p>";
            } elseif((in_array($bulan, $paket3)) or (in_array($bulan, $paket4))) {
                $periode = "<p>Maret - April - Mei</p><p>Juni - Juli - Agustus</p>";
            } else{
                $periode="Data tidak ditemukan";
            }
        }
        elseif ($request->kerjasama == 12) {
            if ((in_array($bulan, $paket1)) or (in_array($bulan, $paket2))) {
                $periode = "<p>September - Oktober - November</p><p>Desember - Januari - Februari</p><p>Maret - April - Mei</p><p>Juni - Juli - Agustus</p>";
            } elseif((in_array($bulan, $paket3)) or (in_array($bulan, $paket4))) {
                $periode = "<p>September - Oktober - November</p><p>Desember - Januari - Februari</p><p>Maret - April - Mei</p><p>Juni - Juli - Agustus</p>";
            } else{
                $periode="Data tidak ditemukan";
            }
        } else{
            $periode="Data tidak ditemukan";
        }

        $company_slug = unique_slug($request->namaperusahaan, 'Cooperation', 'company_slug');
        $application_data = [
            'company_id'            => '01',
            'company_slug'          => $company_slug,
            'company_name'          => $request->namaperusahaan,
            'mulai_paket'           => $request->mulai_paket,
            'akhir_paket'           => $request->akhir_paket,
            'periode'               => $periode,
            'kerjasama'             => $request->kerjasama,
            'pembayaran'            => $request->pembayaran,
            'status'                => $request->status_pembayaran,
        ];


        $user = Auth::user();
        if($user->is_admin() ){
            try {
                $report_update = $report->update($application_data);
                if ($report_update ){
                    return redirect()->back()->with('success', trans('app.report_edit_success_msg'));
                }
            } catch (\Exception $e){
                return redirect()->back()->withInput($request->input())->with('error', $e->getMessage()) ;
            }
        } else{
            return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));
        }

    }


    public function deleteListPerusahaan($id){
        $reports = Cooperation::find($id);
        $user = Auth::user();
        if($user->is_admin() ){
            $reports->delete();
            return back()->with('success', trans('app.cooperation_delete_success_msg'));
        }
        else{
            return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));
        }
    }
}
