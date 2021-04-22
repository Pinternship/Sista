<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Payment;
use App\Models\User;
use App\Models\Post;
use App\Models\FlagJob;
use App\Models\Progdi;
use App\Models\JobFinalReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

use DB;
use Storage;
use File;
use Response;
use PDF;
use App;

class DashboardController extends Controller
{

    // Api
    public function json_lulus($id){
        $bulan = now()->month;
        $tahun = now()->year;
        $code_progdi = ucfirst($id);
        $response = Http::get('http://'.$endpoint.'/skripsi/api/lulus_ipk.php?m='.$bulan.'&y='.$tahun.'&p='.$code_progdi)->json();

        return $response;
    }

    public function json_top_student($id, $angkatan){
        $code_progdi = ucfirst($id);
        $tahun_angkatan = substr($angkatan, -2);
        $response = Http::get('http://'.$endpoint.'/skripsi/api/magang_ipk.php?a='.$tahun_angkatan.'&p='.$code_progdi)->json();

        return $response;
    }

    public function json_chart($id){
        $test_query = "SELECT t1.monthnum, t1.month, coalesce(SUM(t2.usr), 0) AS total
        FROM

        (
          select monthname(100*n+1) as month,
          n as monthnum,
          0 as  usr
          from (select 1 as n union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9 union all select 10 union all select 11 union all select 12) a
        ) t1

        LEFT JOIN

        (
            SELECT MONTH(t.created_at) AS monthnum, MONTHNAME(t.created_at) AS Month, 1 AS usr FROM job_applications t
            WHERE YEAR(t.created_at) = YEAR(CURRENT_TIMESTAMP) AND MONTH(t.created_at) < 12 and job_id = ".$id."
        ) t2


        on t1.monthnum = t2.monthnum
        group by t1.monthnum
        order by t1.monthnum";


        $test_results = DB::select($test_query);

        return $test_results;
    }

    public function json_certificate_progdi($id){
        $data = [];
        $user = Auth::user();
        $code_progdi = ucfirst($id);

        $reports = JobFinalReport::where('nim', 'like', '%'.$code_progdi.'%')->where('status', '=', '0')->orderBy('id', 'desc')->get();

        $data['data'] = $reports;
        return $data;
    }


    // PDF
    public function skpiPdf(Request $request){
        $ch = curl_init('http://'.$endpoint.'/krs_skpi_mhs/index_capkid-091118.php?nimidx23425a3234='.$request->nim);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // get headers too with this line
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $result = curl_exec($ch);
        // get cookie
        // multi-cookie variant contributed by @Combuster in comments
        preg_match_all('/^Set-Cookie:s*([^;]*)/mi', $result, $matches);
        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://'.$endpoint.'/krs_skpi_mhs/php/pdf/laporan.php",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "Cookie: PHPSESSID=".$cookies['PHPSESSID']
          ),
        ));

        $response = curl_exec($curl);

        header('Cache-Control: public'); 
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="SKPI-'.$request->nim.'.pdf"');
        header('Content-Length: '.strlen($response));

        curl_close($curl);

        return ($response);
    }

    public function transkripPdf(Request $request){
        $ch = curl_init('http://'.$endpoint.'/krs_skpi_mhs/index_capkid-091118.php?nimidx23425a3234='.$request->nim);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // get headers too with this line
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $result = curl_exec($ch);
        // get cookie
        // multi-cookie variant contributed by @Combuster in comments
        preg_match_all('/^Set-Cookie:s*([^;]*)/mi', $result, $matches);
        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }


        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://'.$endpoint.'/akademik/pdf/index.php',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array('tpilihh' => 'TRANSKRIP'),
          CURLOPT_HTTPHEADER => array(
            "Cookie: PHPSESSID=".$cookies['PHPSESSID']
          ),
        ));

        $response = curl_exec($curl);

        header('Cache-Control: public'); 
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="SKPI-'.$request->nim.'.pdf"');
        header('Content-Length: '.strlen($response));

        curl_close($curl);

        return ($response);
    }

    // public function transkripPdf(Request $request){
    //     $rules = [
    //         'nim'  => 'required',
    //     ];

    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->fails()){
    //         return redirect()->back()->withInput($request->input())->withErrors($validator);
    //     }

    //     // $url = 'http://'.$endpoint.'/akademik/pdf/index_capk.php';
    //     $url = 'http://'.$endpoint.'/akademik/pdf/index.php';
    //     $terpilih = 'TRANSKRIP';
    //     $myvars = '&tpilihh=' . $terpilih . '&nimy=' . $request->nim;

    //     $ch = curl_init( $url );
    //     curl_setopt( $ch, CURLOPT_POST, 1);
    //     curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
    //     curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    //     curl_setopt( $ch, CURLOPT_HEADER, 0);
    //     curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

    //     $response = curl_exec( $ch );

    //     $url = "http://'.$endpoint.'/akademik/pdf/qrcode_transkrip/".str_replace('.','',$request->nim).".png";
    //     $contents = file_get_contents($url);
    //     $name = substr($url, strrpos($url, '/') + 1);
    //     $imageFileName = 'downloads/qrcode_transkrip/'.$name;
    //     Storage::disk('public')->put($imageFileName, $contents);

    //     $rawreturn = str_replace('img src="qrcode_transkrip/', 'img src="https://midone1.dev/storage/downloads/qrcode_transkrip/', $response);
    //     $rawreturn1 = str_replace('<a href="../index_capkidemik-091118.php?nimidx23425a3234='.$request->nim.'" target="_self"><img src="images/left2.gif"></a>', ' ',$rawreturn);
    //     $return = str_replace('img src="images/logokhs.gif"', 'img src="https://midone1.dev/storage/downloads/qrcode_transkrip/logokhs.gif"', $rawreturn1);
    //     return $return;
    // }

    // View
    public function dashboard(){
        # Auth Seasson
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        # Jobs
        $jobs = $user->jobs()->active()->paginate(5);
        $regular_jobs = Job::active()->orderBy('id', 'desc')->with('employer')->take(10)->get();

        # Progdi
        $progdis =  Progdi::select('*')->get();

        # Applicants
        $applications = JobApplication::where('employer_id', '=', $user_id )->OrderBy('created_at', 'desc')->paginate(5);

        # Flag jobs for admin
        $flagjobs = FlagJob::OrderBy('created_at', 'desc')->paginate(20);

        # Job from faculty
        $user_id_facultys = User::Select('id')->where('created_by', '=', $user->id)->get();
        $job_id_facultys = Job::whereIn('user_id',$user_id_facultys)->get();


        # Data
        $company_tops_applyeds = Job::select('user_id')->selectRaw('sum(applyed) as jumlah')->groupBy('user_id')->orderBy('jumlah', 'desc')->with('employer')->take(5)->get();

        $company_tops_views = Job::select('user_id')->selectRaw('sum(views) as jumlah')->groupBy('user_id')->orderBy('jumlah', 'desc')->with('employer')->take(5)->get();

        $company_tops_jobs = Job::select('user_id')->selectRaw('count(*) as jumlah')->groupBy('user_id')->orderBy('jumlah', 'desc')->with('employer')->take(5)->get();

        $nama_job = $company_tops_jobs->pluck('employer')->pluck('company');
        $jumlah_job = $company_tops_jobs->pluck('jumlah');

        $nama_view = $company_tops_views->pluck('employer')->pluck('company');
        $jumlah_view = $company_tops_views->pluck('jumlah');

        $nama_applyed = $company_tops_applyeds->pluck('employer')->pluck('company');
        $jumlah_applyed = $company_tops_applyeds->pluck('jumlah');

        $totalJob = Job::Where('user_id', '=', $user->id)->count();
        $totalJobActive = Job::Where('user_id', '=', $user->id)->active()->count();
        $totalApplicants_employer = JobApplication::where('employer_id', '=', $user->id)->count();
        $totalApplicants_user = JobApplication::where('user_id', '=', $user->id)->count();
        $totalJobView_employer = Job::Where('user_id', '=', $user->id)->sum('views');

        $title_job_employer = $jobs->pluck('job_title');
        $view_job_employer = $jobs->pluck('views');
        $applyed_job_employer = $jobs->pluck('applyed');

        $created_by = User::select('*')->where('id', '=', $user_id)->get();

        $data = [
            'usersCount' => User::count(),
            'totalPayments' => Payment::success()->sum('amount'),
            'totalJobview' => Job::sum('views'),
            'activeJobs' => Job::active()->count(),
            'totalJobs' => Job::count(),
            'employerCount' => User::employer()->count(),
            'agentCount' => User::agent()->count(),
            'totalApplicants' => JobApplication::count(),
            'totalBlog' =>  Post::count(),
            'totalBlogview' =>  Post::where('status', '=', '1')->sum('views'),
        ];

        # Option
        $is_user_id_view = true;
        $years = array_combine(range(now()->year-1, now()->year-5), range(now()->year-1, now()->year-5));

        return view('admin.dashboard', $data, compact('flagjobs', 'company_tops_applyeds', 'company_tops_views', 'jumlah_applyed', 'nama_applyed', 'nama_view', 'jumlah_view', 'nama_job', 'jumlah_job', 'company_tops_jobs', 'regular_jobs', 'user', 'is_user_id_view', 'totalJob', 'totalJobActive', 'totalApplicants_employer', 'totalApplicants_user', 'totalJobView_employer', 'jobs', 'applications', 'progdis', 'years', 'title_job_employer', 'view_job_employer', 'applyed_job_employer', 'created_by', 'job_id_facultys'));
    }

    public function premium_data(){
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $jobs = $user->jobs()->active()->paginate(5);

        $progdis =  Progdi::select('*')->get();

        $facultys = Progdi::select('*')->where("faculty", "=", $user->faculty)->get();

        $applications = JobApplication::where('employer_id', '=', $user_id )->OrderBy('created_at', 'desc')->paginate(5);

        $flagjobs = FlagJob::OrderBy('created_at', 'desc')->paginate(20);
        $regular_jobs = Job::active()->orderBy('id', 'desc')->with('employer')->take(10)->get();

        $company_tops_applyeds = Job::select('user_id')->selectRaw('sum(applyed) as jumlah')->groupBy('user_id')->orderBy('jumlah', 'desc')->with('employer')->take(5)->get();

        $company_tops_views = Job::select('user_id')->selectRaw('sum(views) as jumlah')->groupBy('user_id')->orderBy('jumlah', 'desc')->with('employer')->take(5)->get();

        $company_tops_jobs = Job::select('user_id')->selectRaw('count(*) as jumlah')->groupBy('user_id')->orderBy('jumlah', 'desc')->with('employer')->take(5)->get();

        $nama_job = $company_tops_jobs->pluck('employer')->pluck('company');
        $jumlah_job = $company_tops_jobs->pluck('jumlah');

        $nama_view = $company_tops_views->pluck('employer')->pluck('company');
        $jumlah_view = $company_tops_views->pluck('jumlah');

        $nama_applyed = $company_tops_applyeds->pluck('employer')->pluck('company');
        $jumlah_applyed = $company_tops_applyeds->pluck('jumlah');

        $totalJob = Job::Where('user_id', '=', $user->id)->count();
        $totalJobActive = Job::Where('user_id', '=', $user->id)->active()->count();
        $totalApplicants_employer = JobApplication::where('employer_id', '=', $user->id)->count();
        $totalApplicants_user = JobApplication::where('user_id', '=', $user->id)->count();
        $totalJobView_employer = Job::Where('user_id', '=', $user->id)->sum('views');

        $data = [
            'usersCount' => User::count(),
            'totalPayments' => Payment::success()->sum('amount'),
            'totalJobview' => Job::sum('views'),
            'activeJobs' => Job::active()->count(),
            'totalJobs' => Job::count(),
            'employerCount' => User::employer()->count(),
            'agentCount' => User::agent()->count(),
            'totalApplicants' => JobApplication::count(),
            'totalBlog' =>  Post::count(),
            'totalBlogview' =>  Post::where('status', '=', '1')->sum('views'),
        ];


        $is_user_id_view = true;
        $years = array_combine(range(now()->year-1, now()->year-5), range(now()->year-1, now()->year-5));

        if ( $user->created_by != '1' ){
            return redirect(route('dashboard'))->with('premium', trans('app.access_restricted_premium_data'));
        }

        return view('admin.premium_data', $data, compact('flagjobs', 'company_tops_applyeds', 'company_tops_views', 'jumlah_applyed', 'nama_applyed', 'nama_view', 'jumlah_view', 'nama_job', 'jumlah_job', 'company_tops_jobs', 'regular_jobs', 'user', 'is_user_id_view', 'totalJob', 'totalJobActive', 'totalApplicants_employer', 'totalApplicants_user', 'totalJobView_employer', 'jobs', 'applications', 'progdis', 'years', 'facultys'));
    }


    //Test
    public function test($id){
        $query = "SELECT id, COUNT(1) as jumlah
                FROM jobs
                GROUP BY user_id
                UNION ALL
                SELECT 'SUM' id, COUNT(1)
                FROM jobs WHERE user_id =".$id;
        $result = DB::select($query);
        return $result;
    }
}
