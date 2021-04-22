public function index(){
    $categorie_tops = Category::orderBy('job_count', 'desc')->take(8)->get();
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
    return view('home', $data, compact('categories', 'premium_jobs', 'regular_jobs', 'packages', 'blog_posts', 'total_users', 'total_companys', 'total_jobs', 'total_applys', 'views', 'categorie_tops', 'company_tops', 'total_user_googles' ));
}