<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\FlagJob;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Progdi;
use App\Mail\ShareByEMail;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class JobController extends Controller
{
    public function newJob(){
        $title = __('app.post_new_job');

        $categories = Category::orderBy('category_name', 'asc')->get();
        // $countries = Country::all();
        $countries = Country::where("country_code", "=", "ID")->get();
        $states = State::where("country_id", "=", "102")->get();
        $old_country = false;
        if (old('country')){
            $old_country = Country::find(old('country'));
        }

        return view('admin.post-new-job', compact('title', 'categories', 'countries', 'old_country', 'states' ));
    }


    public function newJobPost(Request $request){
        $user_id = Auth::user()->id;

        $rules = [
            'job_title' => ['required', 'string', 'max:190'],
            'position' => ['required', 'string', 'max:190'],
            'job_duration' => 'required',
            'category' => 'required',
            'description' => 'required',
            'deadline' => 'required',
        ];
        $this->validate($request, $rules);

        $job_title = $request->job_title;
        $job_slug = unique_slug($job_title, 'Job', 'job_slug');


        $country = Country::find($request->country);
        $state_name = null;
        if ($request->state){
            $state = State::find($request->state);
            $state_name = $state->state_name;
        }


        $job_id = strtoupper(str_random(8));

        if ($request->video_conference == 1){
            $room = "https://g.co/meet/".$job_slug;
        }
        else{
            $room = NULL;
        }


        $data = [
            'user_id'                   => $user_id,
            'job_title'                 => $job_title,
            'job_slug'                  => $job_slug,
            'position'                  => $request->position,
            'category_id'               => $request->category,
            'is_any_where'              => $request->is_any_where,
            'salary'                    => $request->salary,
            'salary_upto'               => $request->salary_upto,
            'is_negotiable'             => $request->is_negotiable,
            'salary_currency'           => "IDR",
            'salary_cycle'              => $request->salary_cycle,
            'vacancy'                   => $request->vacancy,
            'gender'                    => $request->gender,
            'exp_level'                 => $request->exp_level,
            'job_type'                  => $request->job_type,
            'job_duration'              => $request->job_duration,

            'experience_required_years' => $request->experience_required_years,
            'experience_plus'           => $request->experience_plus,
            'description'               => $request->description,
            'skills'                    => $request->skills,
            'responsibilities'          => $request->responsibilities,
            'educational_requirements'  => $request->educational_requirements,
            'experience_requirements'   => $request->experience_requirements,
            'additional_requirements'   => $request->additional_requirements,
            'benefits'                  => $request->benefits,
            'apply_instruction'         => "Login Using Email Student Unika Soegijapranata",
            'country_id'                => "102",
            'country_name'              => "Indonesia",
            'state_id'                  => $request->state,
            'state_name'                => $state_name,
            'city_name'                 => $request->city_name,
            'deadline'                  => $request->deadline,
            'status'                    => 0,
            'is_premium'                => 0,
            'googlemeet_room'           => $room,
        ];


        $job = Job::create($data);
        if ( ! $job){
            return back()->with('error', 'app.something_went_wrong')->withInput($request->input());
        }

        $job->update(['job_id' => $job->id.$job_id]);
        return redirect(route('posted_jobs'))->with('success', __('app.job_posted_success'));
    }


    public function postedJobs(){
        $title = __('app.posted_jobs');
        $user = Auth::user();
        $jobs = $user->jobs()->paginate(5);

        return view('admin.jobs', compact('title', 'jobs','user'));
    }

    public function edit($id){
        $title = __('app.edit_job');
        $job = Job::find($id);

        $user = Auth::user();
        if ( ! $user->is_admin() && $user->id != $job->user_id ){
            return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));
        }

        $categories = Category::orderBy('category_name', 'asc')->get();
        $countries = Country::all();
        $old_country = false;
        if ($job->country_id){
            $old_country = Country::find($job->country_id);
        }

        return view('admin.edit-job', compact('title', 'job','categories','countries', 'old_country'));
    }

    public function postupdatejob(Request $request, $id)
    {
        $rules = [
            'job_title' => ['required', 'string', 'max:190'],
            'position' => ['required', 'string', 'max:190'],
            'job_duration' => 'required',
            'category' => 'required',
            'description' => 'required',
            'deadline' => 'required',
        ];
        $this->validate($request, $rules);

        $slug = str_slug($request->job_title);

        $duplicate = Job::where('job_title', $slug)->where('id', '!=', $id)->count();
        if ($duplicate > 0){
            return back()->with('error', trans('app.category_exists_in_db'));
        }

        $originalDate = $request->deadline;
        $newDate = date("Y-m-d", strtotime($originalDate));


        $data = [
            'job_title'                 => $request->job_title,
            'position'                  => $request->position,
            'category_id'               => $request->category,
            'is_any_where'              => $request->is_any_where,
            'salary'                    => $request->salary,
            'salary_upto'               => $request->salary_upto,
            'is_negotiable'             => $request->is_negotiable,
            'salary_currency'           => $request->salary_currency,
            'salary_cycle'              => $request->salary_cycle,
            'vacancy'                   => $request->vacancy,
            'gender'                    => $request->gender,
            'exp_level'                 => $request->exp_level,
            'job_type'                  => $request->job_type,
            'job_duration'              => $request->job_duration,

            'experience_required_years' => $request->experience_required_years,
            'experience_plus'           => $request->experience_plus,
            'description'               => $request->description,
            'skills'                    => $request->skills,
            'responsibilities'          => $request->responsibilities,
            'educational_requirements'  => $request->educational_requirements,
            'experience_requirements'   => $request->experience_requirements,
            'additional_requirements'   => $request->additional_requirements,
            'benefits'                  => $request->benefits,
            'apply_instruction'         => $request->apply_instruction,
            'country_id'                => $request->country,
            'state_id'                  => $request->state,
            'city_name'                 => $request->city_name,
            'deadline'                  => $newDate,
            'updated_at'                => now(),
        ];
        Job::where('id', $id)->update($data);
        return back()->with('success', trans('app.job_edit_success_msg'));
    }

    /**
     * @param null $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * View any single page
     */
    public function view($slug = null){
        $job = Job::whereJobSlug($slug)->first();

        if ( ! $slug || ! $job || (! $job->is_active() && ! $job->can_edit()) ){
            abort(404);
        }
        $job->views++;
        $job->save();

        $title = $job->job_title;

        try{
            $user_id = Auth::user()->id;
            $applications = JobApplication::whereUserId($user_id)->where('job_id', '=', $job->id)->count();
            return view('job-view', compact('title', 'job', 'applications'));
        }catch (\Exception $e){
            return view('job-view', compact('title', 'job'));
        }
    }

    /**
     * Apply to job
     */
    public function applyJob(Request $request){
        // Rules validate
        $rules = [
        ];

        $validator = Validator::make($request->all(), $rules);

        // Auth
        $user_id = 0;
        if (Auth::check()){
            $user_id = Auth::user()->id;

            // Unika Sisca data
            $user_name = Auth::user()->name;
            $user_email = Auth::user()->email;
        }

        // Unika Sisca data
        $nim_raw = explode("@", $user_email);
        $code_progdi = substr($nim_raw[0], 2, -4);
        $progdi = Progdi::select('*')->where('code', '=', $code_progdi)->first();

        // Split nim for Api
        $codetahun = substr($nim_raw[0], 0, -6);
        $codenim = substr($nim_raw[0], 4);
        $nim = $codetahun.".".strtoupper($code_progdi).".".$codenim;

        // Ipk
        try{
            $url = 'http://'.$endpoint.'/skripsi/api/mhs_aktif.php?nim='.strtoupper($nim);
            $json = file_get_contents($url);
            $obj = json_decode($json);
            $ipk = $obj->ipk;
        }catch (\Exception $e){
            $ipk = 0;
        }


        session()->flash('job_validation_fails', true);

        if ($validator->fails()){
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }

        if ($request->hasFile('resume')){
            // Resume
            $resume = $request->file('resume');
            $valid_extensions = ['pdf','doc','docx'];
            if ( ! in_array(strtolower($resume->getClientOriginalExtension()), $valid_extensions) ){
                session()->flash('job_validation_fails', true);
                return redirect()->back()->withInput($request->input())->with('error', trans('app.resume_file_type_allowed_msg') ) ;
            }

            $file_base_name = str_replace('.'.$resume->getClientOriginalExtension(), '', $resume->getClientOriginalName());
            $resume_name = strtolower(time().str_random(5).'-'.str_slug($file_base_name)).'.' . $resume->getClientOriginalExtension();
            $resumeFileName = 'uploads/resume/'.$resume_name;

            // Image
            $image = $request->file('image');
            $valid_extensions = ['jpg','jpeg','png'];
            if ( ! in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions) ){
                session()->flash('job_validation_fails', true);
                return redirect()->back()->withInput($request->input())->with('error', trans('app.resume_file_type_allowed_msg') ) ;
            }

            $file_base_name = str_replace('.'.$image->getClientOriginalExtension(), '', $image->getClientOriginalName());
            $image_name = strtolower(time().str_random(5).'-'.str_slug($file_base_name)).'.' . $image->getClientOriginalExtension();
            $imageFileName = 'uploads/apply/newphoto/'.$image_name;

            try{
                //Upload original resume
                Storage::disk('public')->put($resumeFileName, file_get_contents($resume));
                //Upload original image
                Storage::disk('public')->put($imageFileName, file_get_contents($image));

                $job = Job::find($request->job_id);

                // Unika job fair costume
                $application_data = [
                    'job_id'                => $request->job_id,
                    'employer_id'           => $job->user_id,
                    'user_id'               => $user_id,
                    'nim'                   => $nim,
                    'progdi'                => $progdi->nama_progdi,
                    'faculty'               => $progdi->faculty,
                    'name'                  => $user_name,
                    'email'                 => $user_email,
                    'ipk'                   => $ipk,
                    'phone_number'          => $request->phone_number,
                    // 'message'               => $request->message,
                    'photo'                 => $image_name,
                    'resume'                => $resume_name,
                    'is_shortlisted'        => 0,
                    'status'                => 0,
                    'transkrip'             => "http://'.$endpoint.'/akademik/index_capkidemik-091118.php?nimidx23425a3234=".$nim,
                    'skpi'                  => "http://'.$endpoint.'/jobsinstansi/pdf1/laporanskpi1.php?nim=".$nim."&bhs=ina&halaman=halaman",
                ];


                JobApplication::create($application_data);

                // Unika Job fair Costume
                // Count Applyed jobs
                $job->applyed++;
                $job->save();

                session()->forget('job_validation_fails');
                return redirect()->back()->withInput($request->input())->with('success', trans('app.job_applied_success_msg')) ;

            } catch (\Exception $e){
                return redirect()->back()->withInput($request->input())->with('error', $e->getMessage()) ;
            }
        }

        return redirect()->back()->withInput($request->input())->with('error', trans('app.error_msg')) ;
    }

    public function flagJob(Request $request, $id){
        $rules = [
            'reason'            => 'required',
            'email'             => 'required',
            'message'           => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            session()->flash('flag_job_validation_fails', true);
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }

        $data = [
            'job_id'    => $id,
            'reason'    => $request->reason,
            'email'     => $request->email,
            'message'   => $request->message,
        ];
        FlagJob::create($data);

        return redirect()->back()->with('success', __('app.job_flag_submitted'));
    }

    public function pendingJobs(){
        $title = __('app.pending_jobs');
        $jobs = Job::pending()->orderBy('id', 'desc')->paginate(20);
        return view('admin.jobs', compact('title', 'jobs'));
    }
    public function approvedJobs(){
        $title = __('app.approved_jobs');
        $jobs = Job::approved()->orderBy('id', 'desc')->paginate(20);
        return view('admin.jobs', compact('title', 'jobs'));
    }
    public function blockedJobs(){
        $title = __('app.approved_jobs');
        $jobs = Job::blocked()->orderBy('id', 'desc')->paginate(20);
        return view('admin.jobs', compact('title', 'jobs'));
    }

    public function flaggedMessage(){
        $title = __('app.flagged_jobs');
        $flagged = FlagJob::orderBy('id', 'desc')->paginate(20);
        return view('admin.flagged_jobs', compact('title', 'flagged'));
    }


    /**
     * @param $job_id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     *
     * Change the job status
     */
    public function statusChange($job_id, $status){
        $job = Job::find($job_id);
        if (! $job->can_edit()){
            return back()->with('error', __('app.permission_denied'));
        }

        if ($status === 'approve'){
            $job->status = 1;
            $job->approved_at = now();
            $job->save();
        }elseif ($status === 'block'){
            $job->status = 2;
            $job->approved_at = now();
            $job->save();
        }elseif ($status === 'unblock'){
            $job->status = 0;
            $job->save();
        }elseif($status === 'delete'){
            $job->delete();
        }elseif($status === 'premium'){
            $balance = $job->employer->premium_jobs_balance;
            if ( ! $balance){
                return back()->with('error', "You don't have any premium jobs balance");
            }
            $job->is_premium = 1;
            $job->save();
            $job->employer->checkJobBalace();
        }elseif($status === 'unpremium'){
            $job->is_premium = 0;
            $job->save();
            $job->employer->checkJobBalace();
        }

        return back()->with('success', __('app.success'));
    }

    public function jobApplicants($job_id){
        $job = Job::find($job_id);

        $title = __('app.applicants')." For ({$job->job_title})";
        $applications = JobApplication::whereJobId($job_id)->orderBy('id', 'desc')->paginate(20);

        return view('admin.applicants', compact('title', 'applications'));
    }

    public function jobsByEmployer($company_slug = null){
        if ( ! $company_slug){
            abort(404);
        }

        $employer = User::whereCompanySlug($company_slug)->first();
        if ( ! $employer){
            abort(404);
        }

        $title = "Jobs by ".$employer->company_name;

        return view('jobs-by-employer', compact('title', 'employer'));
    }


    public function shareByEmail(Request $request){
        $rules = [
            'receiver_name'     => 'required',
            'receiver_email'    => 'email|required',
            'your_name'         => 'required',
            'your_email'        => 'email|required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            session()->flash('share_job_validation_fails', true);
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }

        try{
            Mail::send(new ShareByEMail($request));
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', __('app.job_shared_email_msg'));
    }

    public function jobsListing(Request $request){

        $title = "Browse Jobs";


        $categories = Category::orderBy('category_name', 'asc')->get();
        $countries = Country::where("country_code", "=", "ID")->get();
        $states = State::where("country_id", "=", "102")->get();
        $old_country = false;
        if (old('country')){
            $old_country = Country::find(old('country'));
        }


        $jobs = Job::active();
        $job_counts = Job::count();

        if ($request->q){
            $jobs = $jobs->where(function ($query) use($request){
                $query->where('job_title', 'like', "%{$request->q}%")
                    ->orWhere('position', 'like', "%{$request->q}%")
                    ->orWhere('description', 'like', "%{$request->q}%");
            });
        }

        if ($request->location){
            $jobs = $jobs->where('city_name', 'like', "%{$request->location}%");
        }

        if ($request->gender){
            $jobs = $jobs->whereGender($request->gender);
        }
        if ($request->exp_level){
            $jobs = $jobs->whereExpLevel($request->exp_level);
        }
        if ($request->job_type){
            $jobs = $jobs->whereJobType($request->job_type);
        }
        if ($request->country){
            $jobs = $jobs->whereCountryId($request->country);
        }
        if ($request->state){
            $jobs = $jobs->whereStateId($request->state);
        }
        if ($request->category){
            $jobs = $jobs->whereCategoryId($request->category);
        }

        $jobs = $jobs->orderBy('id', 'desc')->with('employer')->paginate(5);

        return view('jobs', compact('title', 'jobs','categories', 'countries', 'old_country', 'job_counts', 'states' ));
    }


}
