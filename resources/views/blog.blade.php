@extends('layouts.theme')

@section('content')

    <div class="bradcam_area bradcam_bg_1">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text">
                        <h1 style="font-size: 30px;font-weight: 400;text-transform: capitalize;">{!! get_option('site_name') !!} @lang('app.blog')</h1>
                        <p>Get the latest updates from {!! get_option('site_name') !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--================Blog Area =================-->
    <section class="blog_area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="blog_left_sidebar">
                        @foreach($posts as $post)
                        <article class="box blog_item">
                            <div class="blog_item_img">
                                <img class="card-img rounded-0" src="{{$post->feature_image_thumb_uri}}" alt="">
                                <a href="{{route('blog_post_single', $post->slug)}}" class="blog_item_date">
                                    <h3>{{$post->created_at->diffForHumans()}}</h3>
                                    {{-- <p>Jan</p> --}}
                                </a>
                            </div>

                            <div class="blog_details">
                                <a class="d-inline-block" href="{{route('blog_post_single', $post->slug)}}">
                                    <h2>{{$post->title}}</h2>
                                </a>
                                <p>{!! limit_words($post->post_content, 20) !!}</p>
                                <ul class="blog-info-link">
                                    <li><a href="{{route('blog_post_single', $post->slug)}}"><i class="fa fa-user"></i> {{$post->author->name}}</a></li>
                                    <li><a href="{{route('blog_post_single', $post->slug)}}"><i class="fa fa-eye"></i> {{$post->views}}</a></li>
                                </ul>
                            </div>
                        </article>
                        @endforeach

                        <nav class="blog-pagination justify-content-center d-flex">
                            {!! $posts->appends(['q' => request('q')])->links() !!}
                        </nav>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">
                        <aside class="box single_sidebar_widget search_widget">
                            <form method="get">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <input type="text" name="q" value="{{request('q')}}" class="form-control" placeholder='Search Keyword'
                                            onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Search Keyword'">
                                        <div class="input-group-append">
                                            <button class="btn" type="submit"><i class="far fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <button class="button rounded-0 primary-bg text-green w-100 btn_1 boxed-btn"
                                    type="submit">Search</button>
                            </form>
                        </aside>

                        {{-- <aside class="single_sidebar_widget post_category_widget">
                            <h4 class="widget_title">Category</h4>
                            <ul class="list cat-list">
                                <li>
                                    <a href="#" class="d-flex">
                                        <p>Resaurant food</p>
                                        <p>(37)</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="d-flex">
                                        <p>Travel news</p>
                                        <p>(10)</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="d-flex">
                                        <p>Modern technology</p>
                                        <p>(03)</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="d-flex">
                                        <p>Product</p>
                                        <p>(11)</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="d-flex">
                                        <p>Inspiration</p>
                                        <p>21</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="d-flex">
                                        <p>Health Care (21)</p>
                                        <p>09</p>
                                    </a>
                                </li>
                            </ul>
                        </aside> --}}

                        <aside class="box single_sidebar_widget popular_post_widget">
                            <h3 class="widget_title">Recent Post</h3>
                            @foreach($ricents as $ricent)
                            <div class="media post_item">
                                <img src="{{$ricent->feature_image_thumb_uri}}" alt="post" width="30%" height="30%">
                                <div class="media-body">
                                    <a href="{{route('blog_post_single', $ricent->slug)}}">
                                        <h3>{{$ricent->title}}</h3>
                                    </a>
                                    <p>{{$ricent->created_at->diffForHumans()}}</p>
                                </div>
                            </div>
                            @endforeach
                        </aside>
                        <aside class="box single_sidebar_widget tag_cloud_widget">
                            <h4 class="widget_title">Tag Clouds</h4>
                            <ul class="list">
                                <li>
                                    <a href="#">project</a>
                                </li>
                                <li>
                                    <a href="#">admin</a>
                                </li>
                                <li>
                                    <a href="#">job</a>
                                </li>
                                <li>
                                    <a href="#">internship</a>
                                </li>
                            </ul>
                        </aside>


                        <aside class="box single_sidebar_widget instagram_feeds">
                            <h4 class="widget_title">Instagram Feeds</h4>
                            <ul class="instagram_row flex-wrap">
                                @foreach ($profiles->getMedias() as $profile)
                                <li>
                                    <div class="c-link c-link--gray c-tooltip" aria-label="{{ $profile->getLikes() }} Likes">
                                    <a href="{{ $profile->getLink() }}">
                                        <img class="img-fluid"  src="{{ $profile->getThumbnails()['0']->src }}" alt="">
                                    </a>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </aside>

                        <aside class="box single_sidebar_widget newsletter_widget">
                            <h4 class="widget_title">Share</h4>

                            <div class="modern-social-share-wrap">
                                <a href="#" class="btn btn-primary share s_facebook"><i class="la la-facebook"></i> </a>
                                <a href="#" class="btn btn-danger share s_plus"><i class="la la-google-plus"></i> </a>
                                <a href="#" class="btn btn-info share s_twitter"><i class="la la-twitter"></i> </a>
                                <a href="#" class="btn btn-primary share s_linkedin"><i class="la la-linkedin"></i> </a>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================Blog Area =================-->
@endsection

@section('page-js')
    <script src="{{ asset('assets/plugins/SocialShare/SocialShare.js') }}" defer></script>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            (function($) {
                $('.share').ShareLink({
                    title: '{{$post->title}}', // title for share message
                    text: '{{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags($post->description) )),0,160) }}', // text for share message
                    url: '{{route('blog_post_single', $post->slug)}}', // link on shared page
                    class_prefix: 's_', // optional class prefix for share elements (buttons or links or everything), default: 's_'
                    width: 640, // optional popup initial width
                    height: 480 // optional popup initial height
                })

            })(jQuery);
        });
    </script>
@endsection
