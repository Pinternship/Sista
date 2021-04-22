<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

// INSTAGRAM
use Instagram\Api;
use Instagram\Exception\InstagramException;
use Psr\Cache\CacheException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class PostController extends Controller
{
    public function index(Request $request){
        $title = trans('app.pages');

        if ($request->q){
            $pages = Post::where('title', 'like', "%{$request->q}%")->whereType('page')->paginate(20);
        }else{
            $pages = Post::whereType('page')->paginate(20);
        }
        return view('admin.pages', compact('title', 'pages'));
    }

    public function addPage(){
        $title = trans('app.add_page');
        return view('admin.add_page', compact('title'));
    }

    public function store(Request $request){
        $user = Auth::user();
        $rules = [
            'title'     => 'required',
            'post_content'   => 'required',
        ];
        $this->validate($request, $rules);

        $show_in_header_menu = $request->show_in_header_menu ? 1:0;
        $show_in_footer_menu = $request->show_in_footer_menu ? 1:0;

        $slug = unique_slug($request->title, 'Post');
        $data = [
            'user_id'               => $user->id,
            'title'                 => $request->title,
            'slug'                  => $slug,
            'post_content'          => $request->post_content,
            'type'                  => 'page',
            'status'                => '1',
            'show_in_header_menu'   => $show_in_header_menu,
            'show_in_footer_menu'   => $show_in_footer_menu,
        ];

        $post_created = Post::create($data);

        if ($post_created){
            return redirect(route('pages'))->with('success', trans('app.page_has_been_created'));
        }
        return redirect()->back()->with('error', trans('app.error_msg'));
    }

    public function pageEdit($id){
        $title = trans('app.page_edit');
        $page = Post::find($id);
        return view('admin.page_edit', compact('title', 'page'));
    }

    public function pageEditPost(Request $request, $id){
        $rules = [
            'title'     => 'required',
            'post_content'   => 'required',
        ];
        $this->validate($request, $rules);
        $page = Post::find($id);

        $show_in_header_menu = $request->show_in_header_menu ? 1:0;
        $show_in_footer_menu = $request->show_in_footer_menu ? 1:0;

        $data = [
            'title'                 => $request->title,
            'post_content'          => $request->post_content,
            'status'                => 1,
            'show_in_header_menu'   => $show_in_header_menu,
            'show_in_footer_menu'   => $show_in_footer_menu,
        ];

        $post_update = $page->update($data);
        if ($post_update){
            return redirect()->back()->with('success', trans('app.page_has_been_updated'));
        }
        return redirect()->back()->with('error', trans('app.error_msg'));
    }


    public function indexPost(Request $request){
        $title = trans('app.posts');

        if ($request->q){
            $posts = Post::where('title', 'like', "%{$request->q}%")->whereType('post')->paginate(20);
        }else{
            $posts = Post::whereType('post')->paginate(20);
        }
        
        return view('admin.posts', compact('title', 'posts'));
    }

    public function addPost(){
        $title = trans('app.add_post');
        return view('admin.add_post', compact('title'));
    }


    public function storePost(Request $request){

        $user = Auth::user();
        $rules = [
            'title'     => 'required',
            'post_content'   => 'required',
        ];
        $this->validate($request, $rules);

        $slug = unique_slug($request->title, 'Post');
        $data = [
            'user_id'               => $user->id,
            'title'                 => $request->title,
            'slug'                  => $slug,
            'post_content'          => $request->post_content,
            'type'                  => 'post',
            'status'                => '1',
        ];

        $post_created = Post::create($data);

        if ($post_created){
            $feature_image = $this->uploadFeatureImage($request);

            if ($feature_image){
                $post_created->feature_image = $feature_image;
                $post_created->save();
            }

            return redirect(route('posts'))->with('success', trans('app.post_has_been_created'));
        }
        return redirect()->back()->with('error', trans('app.error_msg'));
    }


    public function postEdit($id){
        $title = trans('app.post_edit');
        $post = Post::find($id);
        return view('admin.post_edit', compact('title', 'post'));
    }

    public function postUpdate(Request $request, $id){
        $rules = [
            'title'         => 'required',
            'post_content'  => 'required',
        ];
        $this->validate($request, $rules);
        $post = Post::find($id);

        $show_in_header_menu = $request->show_in_header_menu ? 1:0;
        $show_in_footer_menu = $request->show_in_footer_menu ? 1:0;

        $data = [
            'title'                 => $request->title,
            'post_content'          => $request->post_content,
            'status'                => 1,
        ];

        $post_update = $post->update($data);
        if ($post_update){
            $old_feature_imgae = $post->feature_image;

            $feature_image = $this->uploadFeatureImage($request);
            if ($feature_image){
                if ($old_feature_imgae){
                    $this->deleteFeatureImage($old_feature_imgae);
                }

                $post->feature_image = $feature_image;
                $post->save();
            }


            return redirect()->back()->with('success', trans('app.page_has_been_updated'));
        }
        return redirect()->back()->with('error', trans('app.error_msg'));
    }

    public function uploadFeatureImage($request){

        $imageName = null;
        if ($request->hasFile('feature_image')){
            $image = $request->file('feature_image');

            $valid_extensions = ['jpg','jpeg','png'];
            if ( ! in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions) ){
                return redirect()->back()->withInput($request->input())->with('error', 'Only .jpg, .jpeg and .png is allowed extension') ;
            }
            $file_base_name = str_replace('.'.$image->getClientOriginalExtension(), '', $image->getClientOriginalName());
            $resized_thumb = Image::make($image)->resize(null, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->stream();

            $imageName = strtolower(time().str_random(5).'-'.str_slug($file_base_name)).'.' . $image->getClientOriginalExtension();

            try{
                Storage::disk('public')->putFileAs('uploads/images/blog/full/', $image, $imageName);
                Storage::disk('public')->put('uploads/images/blog/thumb/'.$imageName, $resized_thumb->__toString());
            } catch (\Exception $e){
                return redirect()->back()->withInput($request->input())->with('error', $e->getMessage()) ;
            }
        }

        return $imageName;
    }

    public function deleteFeatureImage($image = null){
        if ( ! $image){
            return;
        }
        Storage::disk('public')->delete('uploads/images/blog/full/'.$image);
        Storage::disk('public')->delete('uploads/images/blog/thumb/'.$image);
    }

    public function blogIndex(){
        // $response = file_get_contents('https://www.instagram.com/ssccunikasoegijapranata/?__a=1');
        // $igs = json_decode($response);

        // INSTGARAM
        $cachePool = new FilesystemAdapter('Instagram', 0, __DIR__ . '/../cache');
        $api = new Api($cachePool);
        $api->login('oldfolkscover', 'ilham211');
        $profiles = $api->getProfile('ssccunikasoegijapranata');

        $title = get_option('site_name').' '.__('app.blog');


        $posts = Post::whereType('post');
            if (\request('q')){
                $posts = $posts->where(function ($query){
                    $term = \request('q');
                    $query->where('title', 'like', "%{$term}%")->orWhere('post_content', 'like', "%{$term}%");
                });
            }
        $posts = $posts->orderBy('id', 'desc')->paginate(5);

        $ricents = Post::orderBy('id', 'desc')->take(4)->get();

        return view('blog', compact('title', 'posts', 'profiles', 'ricents' ));
    }

    public function view($slug){
        $post = Post::whereSlug($slug)->first();

        if ( ! $slug || ! $post){
            abort(404);
        }
        $post->views++;
        $post->save();

        $title = $post->title;
        return view('blog-view', compact('title', 'post'));
    }

    public function showPage($slug){
        $page = Post::whereSlug($slug)->first();

        if ( ! $slug || ! $page){
            abort(404);
        }
        $page->views++;
        $page->save();

        $title = $page->title;
        return view('page', compact('title', 'page'));
    }

    public function statusChange($post_id, $status){
        if($status === 'delete'){
            $delete = Post::where('id', $post_id)->delete();
            if ($delete){
                return back()->with('success', __('app.deleted_success'));
            }
            return back()->with('success', __('app.error_msg'));
        }
    }


}