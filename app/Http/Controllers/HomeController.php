<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\User;
use App\Models\JobApplication;
use App\Models\Post;
use App\Models\Pricing;
use App\Mail\ContactUs;
use App\Mail\ContactUsSendToSender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

use Goutte\Client;
use DOMDocument;
use DOMXpath;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $categorie_tops = Category::orderBy('job_count', 'desc')->take(8)->get();
        // $company_tops = User::where("user_type", "=", "employer")->with('jobs')->get();
        $company_tops = Job::select('user_id')->selectRaw('sum(applyed) as jumlah')->groupBy('user_id')->orderBy('jumlah', 'desc')->with('employer')->get();
        $categories = Category::orderBy('category_name', 'asc')->get();
        $premium_jobs = Job::active()->premium()->orderBy('id', 'desc')->with('employer')->get();
        $regular_jobs = Job::active()->orderBy('id', 'desc')->with('employer')->take(15)->get();
        $total_jobs = Job::where('status', '=', '1')->count();
        $blog_posts = Post::whereType('post')->with('author')->orderBy('id', 'desc')->take(3)->get();
        $total_users = User::where('active_status', '=', '1')->count();
        $total_user_googles = User::where('user_type', '=', 'user')->count();
        $total_companys = User::whereNotNull('company')->count();
        $data['count'] = User::whereNotNull('company')->count();
        $views = Job::whereNotNull('views')->orderBy('views', 'desc')->take(7)->get();
        $total_applys = JobApplication::count();
        $packages = Pricing::all();
        // $job = Job::select("*")->get();

        // $post = [
        //     'user' => '15.N1.0012',
        //     'pass' => '21/10/1996',
        // ];

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'http://sintak.unika.ac.id/id/validate.php');
        // curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        // curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie-name');  //could be empty, but cause problems on some hosts
        // // curl_setopt($ch, CURLOPT_COOKIEFILE, '/var/www/ip4.x/file/tmp');  //could be empty, but cause problems on some hosts
        // $responses = curl_exec($ch);

        // curl_setopt($ch, CURLOPT_URL, 'http://sintak.unika.ac.id/id/transkrip.php');
        // curl_setopt($ch, CURLOPT_POST, false);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, "");
        // $transkrips = curl_exec($ch);

        // $dom = new DOMDocument();
        // libxml_use_internal_errors(true);
        // $dom->loadHTML($transkrips);
        // libxml_clear_errors();
        // $xpath = new DOMXpath($dom);
        // $datas = array();
        // $table_rows = $xpath->query('//table/tr');
        // foreach($table_rows as $row => $tr) {
        //     foreach($tr->childNodes as $td) {
        //         $datas[$row][] = preg_replace('~[\r\n]+~', '', trim($td->nodeValue));
        //     }
        //     $datas[$row] = array_values(array_filter($datas[$row]));
        // }

        // $jsons  = [$datas[0][2], $datas[1][2], $datas[7][2], $datas[8][2]];


        return view('home', $data, compact('categories', 'premium_jobs', 'regular_jobs', 'packages', 'blog_posts', 'total_users', 'total_companys', 'total_jobs', 'total_applys', 'views', 'categorie_tops', 'company_tops', 'total_user_googles' ));
    }

    public function newRegister(){
        $title = __('app.register');
        return view('new_register', compact('title'));
    }

    public function pricing(){
        $title = __('app.pricing');
        $packages = Pricing::all();
        return view('pricing', compact('title', 'packages'));
    }

    public function contactUs(){
        $title = trans('app.contact_us');
        return view('contact_us', compact('title'));
    }

    public function contactUsPost(Request $request){
        $rules = [
            'name'  => 'required',
            'email'  => 'required|email',
            'subject'  => 'required',
        ];

        $this->validate($request, $rules);

        try{
            Mail::send(new ContactUs($request));
            Mail::send(new ContactUsSendToSender($request));
        }catch (\Exception $exception){
            return redirect()->back()->with('error', '<h4>'.trans('app.smtp_error_message').'</h4>'. $exception->getMessage());
        }

        return redirect()->back()->with('success', trans('app.message_has_been_sent'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * Clear all cache
     */
    public function clearCache(){
        Artisan::call('debugbar:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        if (function_exists('exec')){
            exec('rm ' . storage_path('logs/*'));
        }
        return redirect(route('home'));
    }

}
