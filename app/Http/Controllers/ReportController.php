<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\JobFinalReport;
use App\Models\JobMonthlyReport;
use App\Models\JobApplication;
use App\Models\State;
use App\Models\User;
use App\Models\Job;
use App\Models\Progdi;

use PDF;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Illuminate\Support\Facades\Mail;
use App\Mail\AcceptMail;

use Kyslik\ColumnSortable\Sortable;

class ReportController extends Controller
{

    /**
     * @param $id
     * @param null $status
     * @return \Illuminate\Http\RedirectResponse
     */

    public $sortable = ['job_id'];

    // Monthly Report
    public function MonthlyReport(){
        $title = __('app.report_perusahaan_bulanan');
        $employer_id = Auth::user()->id;
        $user = Auth::user();
        if ($user->is_admin()){
            $applications = JobApplication::where('status', '=', '1')->where('user_status', '=', '1')->orderBy('id', 'desc')->get();
        }elseif ($user->is_faculty()) {
            $applications = JobApplication::where('faculty', '=', $user->faculty)->where('status', '=', '1')->where('user_status', '=', '1')->orderBy('id', 'desc')->get();
        }else{
            $applications = JobApplication::whereEmployerId($employer_id)->where('status', '=', '1')->where('user_status', '=', '1')->orderBy('id', 'desc')->get();
        }


        return view('admin.report_monthly', compact('title', 'applications'));
    }

    public function addMonthlyReport($id){
        $title = __('app.add_monthly_report');
        $application = JobApplication::find($id);
        $job = Job::find($application->job_id);
        $user = Auth::user();
        if ($application->employer_id == $user->id ){
            return view('admin.add_report', compact('title', 'application', 'job' ));
        }
        elseif($user->is_admin() ){
            return view('admin.add_report', compact('title', 'application', 'job' ));
        }
        else{
            return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));
        }
    }

    public function postMonthlyReport(Request $request, $id){
        // Get Faculty Code
        $nim_raw = explode("@", $request->email);
        $code_progdi = substr($nim_raw[0], 2, -4);
        $progdi = Progdi::select('*')->where('code', '=', $code_progdi)->first();

        $rules = [
            'report'    => 'required',
        ];
        $this->validate($request, $rules);

        $user_id = 0;
        if (Auth::check()){
            $user_id = Auth::user()->id;
        }

        try {
            $application_data = [
                'faculty'               => $progdi->faculty,
                'application_id'        => $request->application_id,
                'employer_id'           => $user_id,
                'user_id'               => $request->user_id,
                'job_id'                => $request->job_id,
                'nim'                   => $request->nim,
                'name'                  => $request->name,
                'progdi'                => $request->progdi,
                'email'                 => $request->email,
                'report'                => $request->report,
                'status'                => '0',
            ];
            JobMonthlyReport::create($application_data);
            return back()->with('success', trans('app.report_add_success_msg'));
        } catch (\Exception $e){
            return redirect()->back()->withInput($request->input())->with('error', $e->getMessage()) ;
        }
    }

    public function viewMonthlyReport($id){
        $title = __('app.view_monthly_report');
        $application = JobApplication::find($id);
        $job = Job::find($application->job_id);

        $user = Auth::user();

        $reports = JobMonthlyReport::where('user_id', '=', $application->user_id)->where('status', '=', '0')->orderBy('id', 'desc')->paginate(5);
        
        if ($application->employer_id == $user->id ){
            return view('admin.view_report_monthly', compact('title', 'job', 'reports' ));
        }
        elseif($user->is_admin() ){
            return view('admin.view_report_monthly', compact('title', 'job', 'reports' ));
        }
        elseif($user->is_faculty() ){
             $reports = JobMonthlyReport::where('faculty', '=', $user->faculty)->where('status', '=', '0')->orderBy('id', 'desc')->paginate(5);
            return view('admin.view_report_monthly', compact('title', 'job', 'reports' ));
        }
        else{
            return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));
        }
    }

    public function editMonthlyReport($id){
        $title = __('app.report_edit');
        $report = JobMonthlyReport::find($id);

        $user = Auth::user();
        return view('admin.edit_report', compact('title', 'report'));
    }

    public function posteditMonthlyReport(Request $request, $id){
        $report = JobMonthlyReport::find($id);

        $rules = [
            'report'    => 'required',
        ];
        $this->validate($request, $rules);

        $user_id = 0;
        if (Auth::check()){
            $user_id = Auth::user()->id;
        }

        try {
            $data = [
                'report'    => $request->report,
            ];

            $report_update = $report->update($data);
            if ($report_update ){
                return redirect()->back()->with('success', trans('app.report_edit_success_msg'));
            }
        } catch (\Exception $e){
            return redirect()->back()->withInput($request->input())->with('error', $e->getMessage()) ;
        }
    }

    public function deleteMonthlyReport($id){
        $application = JobApplication::find($id);
        $reports = JobMonthlyReport::find($id);
        $user = Auth::user();
        if ($user->is_employer()){
            $reports->delete();
            return back()->with('success', trans('app.report_add_success_msg'));
        }
        elseif($user->is_admin() ){
            $reports->delete();
            return back()->with('success', trans('app.report_add_success_msg'));
        }
        else{
            return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));
        }
    }



    //Final Report
    public function FinalReport(){
        $title = __('app.report_akhir');
        $employer_id = Auth::user()->id;

        $user = Auth::user();
        if ($user->is_admin()){
            $applications = JobApplication::where('status', '=', '1')->where('user_status', '=', '1')->orderBy('id', 'desc')->get();
        }elseif ($user->is_faculty()){
            $applications = JobApplication::where('faculty', '=', $user->faculty)->where('status', '=', '1')->where('user_status', '=', '1')->orderBy('id', 'desc')->get();
        }else{
            $applications = JobApplication::whereEmployerId($employer_id)->where('user_status', '=', '1')->where('status', '=', '1')->orderBy('id', 'desc')->get();
        }

        return view('admin.report_final', compact('title', 'applications'));
    }

    public function userFinalReport(){
        $title = __('app.view_final_report');
        $user = Auth::user();
        $user_id = 0;
        if (Auth::check()){
            $user_id = Auth::user()->id;
        }

        $reports = JobFinalReport::where('user_id', '=', $user_id)->where('status', '=', '0')->orderBy('id', 'desc')->paginate(5);

        return view('admin.view_report_final_user', compact('title', 'reports', 'user' ));
    }


    public function addfinalReport($id){
        $title = __('app.add_final_report');
        $application = JobApplication::find($id);
        $job = Job::find($application->job_id);
        $user = Auth::user();
        try{
            $report = JobMonthlyReport::where('user_id', '=', $application->user_id)->get();
        }catch (\Exception $e){
            $report = JobMonthlyReport::find($id);
        }


        if ($application->employer_id == $user->id ){
            return view('admin.add_finalreport', compact('title', 'application', 'job', 'report' ));
        }
        elseif($user->is_admin() ){
            return view('admin.add_finalreport', compact('title', 'application', 'job', 'report' ));
        }
        else{
            return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));
        }
    }

    public function postFinalReport(Request $request, $id ){
        $application = JobApplication::find($id);
        $report = JobMonthlyReport::where('user_id', '=', $application->user_id)->get();
        $job = Job::find($application->job_id);

        // Get Faculty Code
        $nim_raw = explode("@", $request->email);
        $code_progdi = substr($nim_raw[0], 2, -4);
        $progdi = Progdi::select('*')->where('code', '=', $code_progdi)->first();

        $rules = [
            'report'    => 'required',
            'nilai'     => 'required',
        ];
        $this->validate($request, $rules);

        $user_id = 0;
        if (Auth::check()){
            $user_id = Auth::user()->id;
        }

        if (count($report) == $job->job_duration){
            try {
                $application_data = [
                    'faculty'               => $progdi->faculty,
                    'application_id'        => $request->application_id,
                    'employer_id'           => $user_id,
                    'user_id'               => $request->user_id,
                    'job_id'                => $request->job_id,
                    'nim'                   => $request->nim,
                    'name'                  => $request->name,
                    'progdi'                => $request->progdi,
                    'email'                 => $request->email,
                    'report'                => $request->report,
                    'nilai'                 => $request->nilai,
                    'status'                => '0',
                ];
                JobFinalReport::create($application_data);
                return back()->with('success', trans('app.report_add_success_msg'));
            } catch (\Exception $e){
                return redirect()->back()->withInput($request->input())->with('error', $e->getMessage()) ;
            }
        }else{
            return redirect()->back()->with('error', trans('app.duration_not_reached'));
        }
    }

    public function viewFinalReport($id){
        $title = __('app.view_final_report');
        $application = JobApplication::find($id);
        $job = Job::find($application->job_id);

        $reports = JobFinalReport::where('user_id', '=', $application->user_id)->where('status', '=', '0')->orderBy('id', 'desc')->paginate(5);
        $user = Auth::user();
        if ($application->employer_id == $user->id ){
            return view('admin.view_report_final', compact('title', 'job', 'reports', 'user' ));
        }
        elseif($user->is_admin() ){
            return view('admin.view_report_final', compact('title', 'job', 'reports', 'user' ));
        }
        elseif($user->is_faculty()){
             $reports = JobFinalReport::where('faculty', '=', $user->faculty)->where('status', '=', '0')->orderBy('id', 'desc')->paginate(5);
            return view('admin.view_report_final', compact('title', 'job', 'reports' ));  
        }
        else{
            return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));
        }
    }

    public function editFinalReport($id){
        $title = __('app.report_edit');
        $report = JobFinalReport::find($id);

        $user = Auth::user();
        return view('admin.edit_report_final', compact('title', 'report'));
    }

    public function posteditFinalReport(Request $request, $id){
        $report = JobFinalReport::find($id);

        $rules = [
            'report'    => 'required',
            'nilai'     => 'required',
        ];
        $this->validate($request, $rules);

        $user_id = 0;
        if (Auth::check()){
            $user_id = Auth::user()->id;
        }

        try {
            $data = [
                'report'    => $request->report,
                'nilai'    => $request->nilai,
            ];

            $report_update = $report->update($data);
            if ($report_update ){
                return redirect()->back()->with('success', trans('app.report_edit_success_msg'));
            }
        } catch (\Exception $e){
            return redirect()->back()->withInput($request->input())->with('error', $e->getMessage()) ;
        }
    }

    public function deleteFinalReport($id){
        $application = JobApplication::find($id);
        $reports = JobFinalReport::find($id);
        $user = Auth::user();

        if ($user->is_employer()){
            $reports->delete();
            return back()->with('success', trans('app.report_add_success_msg'));
        }
        elseif($user->is_admin() ){
            $reports->delete();
            return back()->with('success', trans('app.report_add_success_msg'));
        }
        else{
            return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));
        }
    }

    public function pdfFinalReport($id){
        $application = JobApplication::find($id);
        $month = JobMonthlyReport::find($id);
        $final = JobFinalReport::find($id);

        $company = User::find($final->employer_id);
        $job = Job::find($final->job_id);

        $path = storage_path('app\public\uploads\images\logos\\'.$company->logo);
        $image = base64_encode(file_get_contents($path));

        $user = Auth::user();

        $pdf = PDF::loadView('pdf.report', compact('month', 'final', 'company', 'job', 'image'));
        return $pdf->download('report_'.$final->nim.'.pdf');

        // return view('pdf.report', compact('month', 'final', 'company', 'job', 'image'));
    }
}
