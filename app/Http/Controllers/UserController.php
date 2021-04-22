<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\JobApplication;
use App\Models\State;
use App\Models\User;
use App\Models\Job;
use App\Models\Progdi;
use App\Models\Faculty;

use DataTables;
use Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Illuminate\Support\Facades\Mail;
use App\Mail\AcceptMail;

class UserController extends Controller
{

    // public function json(){
    //     return Datatables::of(User::all())->make(true);
    // }

    public function index(Request $request){
        $title = trans('app.users');
        $current_user = Auth::user();

        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        if ( $user->is_admin()){
            if ($request->q){
                $users = User::where('name', 'like', "%{$request->q}%")->orderBy('name', 'asc')->paginate(20);
            }else{
                $users = User::where('id', '!=', $current_user->id)->orderBy('name', 'asc')->paginate(20);
            }

            return view('admin.users', compact('title', 'users', 'user'));
        }
        elseif($user->is_faculty()){
            if ($request->q){
                $users = User::where('name', 'like', "%{$request->q}%")->orderBy('name', 'asc')->paginate(20);
            }else{
                $users = User::where('id', '!=', $current_user->id)->where('created_by', '=', $current_user->id)->orderBy('name', 'asc')->paginate(20);
            }

            return view('admin.users', compact('title', 'users', 'user'));
        }
        else{
            return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));
        }
    }


    public function show($id = 0){
        if ($id){
            $title = trans('app.profile');
            $user = User::find($id);

            $totalJob = Job::Where('user_id', '=', $user->id)->count();
            $totalJobActive = Job::Where('user_id', '=', $user->id)->active()->count();
            $totalApplicants = JobApplication::where('employer_id', '=', $user->id)->count();
            $totalApplicants_user = JobApplication::where('user_id', '=', $user->id)->count();
            $totalJobView = Job::Where('user_id', '=', $user->id)->sum('views');

            $is_user_id_view = true;
            return view('admin.profile', compact('title', 'user', 'is_user_id_view', 'totalJob', 'totalJobActive', 'totalApplicants', 'totalApplicants_user', 'totalJobView'));
        }
    }

    /**
     * @param $id
     * @param null $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function statusChange($id, $status = null){
        if(config('app.is_demo')){
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }

        $user = User::find($id);
        if ($user && $status){
            if ($status == 'approve'){
                $user->active_status = 1;
                $user->save();

            }elseif($status == 'block'){
                $user->active_status = 2;
                $user->save();
            }
            elseif($status == 'pending'){
                $user->active_status = 3;
                $user->save();
            }     
            elseif($status == 'delete'){
                $user->active_status = 4;
                $user->save();
            }           
        }
        return back()->with('success', trans('app.status_updated'));
    }

    public function appliedJobs(){
        $title = __('app.applicant');
        $user_id = Auth::user()->id;
        $applications = JobApplication::whereUserId($user_id)->orderBy('id', 'desc')->paginate(10);

        return view('admin.applied_jobs', compact('title', 'applications'));
    }

    public function registerJobSeeker(){
        $title = __('app.register_job_seeker');
        return view('register-job-seeker', compact('title'));
    }

    public function registerJobSeekerPost(Request $request){
        $rules = [
            'name' => ['required', 'string', 'max:190'],
            'email' => ['required', 'string', 'email', 'max:190', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];

        $this->validate($request, $rules);

        $data = $request->input();
        User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'user_type'     => 'user',
            'password'      => Hash::make($data['password']),
            'active_status' => 1,
        ]);

        return redirect(route('login'))->with('success', __('app.registration_successful'));
    }

    public function registerEmployer(){
        $title = __('app.employer_register');

        $countries = Country::where("country_code", "=", "ID")->get();
        $states = State::where("country_id", "=", "102")->get();
        $old_country = false;
        if (old('country')){
            $old_country = Country::find(old('country'));
        }

        return view('employer-register', compact('title', 'countries', 'states'));
    }

    public function registerEmployerPost(Request $request){
        $user = Auth::user();

        $rules = Validator::make($request->all(), [
            'name'          => 'required|string|max:190',
            'company'       => 'required',
            'email'         => 'required|string|email|max:190|unique:users',
            'password'      => 'required|string|min:6|confirmed',
            'phone'         => 'required',
            'address'       => 'required',
            'state'         => 'required',
        ]);
        // $this->validate($request, $rules);

        $company = $request->company;
        $company_slug = unique_slug($company, 'User', 'company_slug');

        $country = Country::find($request->country);
        $state_name = null;
        if ($request->state){
            $state = State::find($request->state);
            $state_name = $state->state_name;
        }

        try{
            User::create([
                'created_by'    => $user->id,
                'name'          => $request->name,
                'company'       => $company,
                'company_slug'  => $company_slug,
                'email'         => $request->email,
                'user_type'     => 'employer',
                'password'      => Hash::make($request->password),
                'country_id'    => '102',
                'company_size'  => 'A',
                'phone'         => $request->phone,
                'address'       => $request->address,
                'address_2'     => $request->address_2,
                'country_id'    => $request->country,
                'country_name'  => $country->country_name,
                'state_id'      => $request->state,
                'state_name'    => $state_name,
                'city'          => $request->city,
                'active_status' => 1,
                'logo'          => 'company.png',
            ]);

            return redirect()->back()->with('success', __('app.registration_successful'));
        } catch (\Exception $e){
            return redirect()->back()->withInput($request->input())->with('error', __('app.registration_unsuccessful')) ;
        }
    }


    public function registerAgent(){
        $title = __('app.agent_register');
        $countries = Country::all();
        $old_country = false;
        if (old('country')){
            $old_country = Country::find(old('country'));
        }
        return view('agent-register', compact('title', 'countries', 'old_country'));
    }

    public function registerAgentPost(Request $request){
        $rules = [
            'name'      => ['required', 'string', 'max:190'],
            'company'   => 'required',
            'email'     => ['required', 'string', 'email', 'max:190', 'unique:users'],
            'password'  => ['required', 'string', 'min:6', 'confirmed'],
            'phone'     => 'required',
            'address'   => 'required',
            'country'   => 'required',
            'state'     => 'required',
        ];
        $this->validate($request, $rules);

        $company = $request->company;
        $company_slug = unique_slug($company, 'User', 'company_slug');

        $country = Country::find($request->country);
        $state_name = null;
        if ($request->state){
            $state = State::find($request->state);
            $state_name = $state->state_name;
        }

        User::create([
            'name'          => $request->name,
            'company'       => $company,
            'company_slug'  => $company_slug,
            'email'         => $request->email,
            'user_type'     => 'agent',
            'password'      => Hash::make($request->password),

            'phone'         => $request->phone,
            'address'       => $request->address,
            'address_2'     => $request->address_2,
            'country_id'    => $request->country,
            'country_name'  => $country->country_name,
            'state_id'      => $request->state,
            'state_name'    => $state_name,
            'city'          => $request->city,
            'active_status' => 1,
        ]);

        return redirect(route('login'))->with('success', __('app.registration_successful'));
    }


    public function registerFaculty(){
        $facultys = Faculty::get();


        $title = __('app.faculty_register');
        return view('register-faculty', compact('title', 'facultys'));
    }

    public function registerFacultyPost(Request $request){
        $user = Auth::user();

        $rules = [
            'name' => ['required', 'string', 'max:190'],
            'email' => ['required', 'string', 'email', 'max:190', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];

        $this->validate($request, $rules);

        $data = $request->input();

        try{
            User::create([
                'name'          => $data['name'],
                'email'         => $data['email'],
                'created_by'    => $user->id,
                'faculty'       => $data['faculty'],
                'user_type'     => 'faculty',
                'password'      => Hash::make($data['password']),
                'active_status' => 1,
            ]);

            return redirect()->back()->with('success', __('app.registration_successful'));
        } catch (\Exception $e){
            return redirect()->back()->withInput($request->input())->with('error', __('app.registration_unsuccessful')) ;
        }
    }


    public function employerProfile(){
        $title = __('app.employer_profile');
        $user = Auth::user();

        $totalJob = Job::Where('user_id', '=', $user->id)->count();
        $totalJobActive = Job::Where('user_id', '=', $user->id)->active()->count();
        $totalApplicants = JobApplication::where('employer_id', '=', $user->id)->count();
        $totalJobView = Job::Where('user_id', '=', $user->id)->sum('views');

        $countries = Country::all();
        $old_country = false;
        if ($user->country_id){
            $old_country = Country::find($user->country_id);
        }

        return view('admin.employer-profile', compact('title', 'user', 'countries', 'old_country', 'totalJob', 'totalJobActive', 'totalApplicants', 'totalJobView'));
    }

    public function employerProfilePost(Request $request){
        $user = Auth::user();

        $rules = [
            'company_size'   => 'required',
            'phone'     => 'required',
            'address'   => 'required',
            'country'   => 'required',
            'state'     => 'required',
        ];

        $this->validate($request, $rules);


        $logo = null;
        if ($request->hasFile('logo')){
            $image = $request->file('logo');

            $valid_extensions = ['jpg','jpeg','png'];
            if ( ! in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions) ){
                return redirect()->back()->withInput($request->input())->with('error', 'Only .jpg, .jpeg and .png is allowed extension') ;
            }
            $file_base_name = str_replace('.'.$image->getClientOriginalExtension(), '', $image->getClientOriginalName());
            $resized_thumb = Image::make($image)->resize(256, 256)->stream();

            $logo = strtolower(time().str_random(5).'-'.str_slug($file_base_name)).'.' . $image->getClientOriginalExtension();

            $logoPath = 'uploads/images/logos/'.$logo;

            try{
                Storage::disk('public')->put($logoPath, $resized_thumb->__toString());
            } catch (\Exception $e){
                return redirect()->back()->withInput($request->input())->with('error', $e->getMessage()) ;
            }
        }

        $country = Country::find($request->country);
        $state_name = null;
        if ($request->state){
            $state = State::find($request->state);
            $state_name = $state->state_name;
        }

        $data = [
            'company'       => $request->company,
            'company_size'  => $request->company_size,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'address_2'     => $request->address_2,
            'country_id'    => $request->country,
            'country_name'  => $country->country_name,
            'state_id'      => $request->state,
            'state_name'    => $state_name,
            'city'          => $request->city,
            'about_company' => $request->about_company,
            'website'       => $request->website,
        ];

        if ($logo){
            $data['logo'] = $logo;
        }

        $user->update($data);

        return back()->with('success', __('app.updated'));
    }


    public function employerApplicant(){
        $title = __('app.applicant');
        $employer_id = Auth::user()->id;
        $applications = JobApplication::whereEmployerId($employer_id)->where('is_shortlisted', '=', '0')->orderBy('id', 'desc')->paginate(5);

        return view('admin.applicants', compact('title', 'applications'));
    }

    public function makeShortList($application_id){
        $applicant = JobApplication::find($application_id);
        $applicant->is_shortlisted = 1;
        $applicant->save();
        return back()->with('success', __('app.success'));
    }

    public function removeShortList($application_id){
        $applicant = JobApplication::find($application_id);
        $applicant->is_shortlisted = 0;
        $applicant->save();
        return back()->with('success', __('app.success'));
    }

    public function acceptList($application_id){
        $applicant = JobApplication::find($application_id);
        $applicant->status = 1;
        $applicant->save();

        Mail::to($applicant->email)->send(new AcceptMail($applicant->job_id));

        return back()->with('success', __('app.accept_notification_success'));
    }

    public function acceptJob($application_id){
        $applicant = JobApplication::find($application_id);
        $applicant->user_status = 1;
        $applicant->save();
        return back()->with('success', __('app.success'));
    }

    public function removeacceptJob($application_id){
        $applicant = JobApplication::find($application_id);
        $applicant->user_status = 0;
        $applicant->save();
        return back()->with('success', __('app.success'));
    }


    public function removeAcceptList($application_id){
        $applicant = JobApplication::find($application_id);
        $applicant->status = 0;
        $applicant->save();
        return back()->with('success', __('app.success'));
    }

    public function shortlistedApplicant(){
        $title = __('app.shortlisted');
        $employer_id = Auth::user()->id;
        $applications = JobApplication::whereEmployerId($employer_id)->whereIsShortlisted(1)->where('status', '=', '0')->orderBy('id', 'desc')->paginate(5);

        return view('admin.applicants', compact('title', 'applications'));
    }

    public function acceptedApplicant(Request $request){
        $title = __('app.accepted');
        $employer_id = Auth::user()->id;
        $applications = JobApplication::whereEmployerId($employer_id)->whereIsShortlisted(1)->where('status', '=', '1')->orderBy('id', 'desc')->paginate(5);

        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.applicants', compact('title', 'applications'));
    }


    public function profile(){
        $title = trans('app.profile');
        $user = Auth::user();

        $totalJob = Job::Where('user_id', '=', $user->id)->count();
        $totalJobActive = Job::Where('user_id', '=', $user->id)->active()->count();
        $totalApplicants = JobApplication::where('employer_id', '=', $user->id)->count();
        $totalApplicants_user = JobApplication::where('user_id', '=', $user->id)->count();
        $totalJobView = Job::Where('user_id', '=', $user->id)->sum('views');

        return view('admin.profile', compact('title', 'user', 'totalJob', 'totalJobActive', 'totalApplicants', 'totalApplicants_user', 'totalJobView'));
    }

    public function profileEdit($id = null){
        $title = trans('app.profile_edit');
        $user = Auth::user();

        if ($id){
            $user = User::find($id);
        }

        $countries = Country::all();

        return view('admin.profile_edit', compact('title', 'user', 'countries'));
    }

    public function profileEditPost($id = null, Request $request){
        if(config('app.is_demo')){
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }

        $user = Auth::user();
        if ($id){
            $user = User::find($id);
        }
        //Validating
        $rules = [
            'email'    => 'required|email|unique:users,email,'.$user->id,
        ];
        $this->validate($request, $rules);

        $inputs = array_except($request->input(), ['_token', 'photo']);
        $user->update($inputs);

        return back()->with('success', trans('app.profile_edit_success_msg'));
    }


    public function changePassword()
    {
        $title = trans('app.change_password');
        return view('admin.change_password', compact('title'));
    }

    public function changePasswordPost(Request $request)
    {
        if(config('app.is_demo')){
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }
        $rules = [
            'old_password'  => 'required',
            'new_password'  => 'required|confirmed',
            'new_password_confirmation'  => 'required',
        ];
        $this->validate($request, $rules);

        $old_password = $request->old_password;
        $new_password = $request->new_password;
        //$new_password_confirmation = $request->new_password_confirmation;

        if(Auth::check())
        {
            $logged_user = Auth::user();

            if(Hash::check($old_password, $logged_user->password))
            {
                $logged_user->password = Hash::make($new_password);
                $logged_user->save();
                return redirect()->back()->with('success', trans('app.password_changed_msg'));
            }
            return redirect()->back()->with('error', trans('app.wrong_old_password'));
        }
    }

}
