@extends('page::frontend.layout.master')
@section('meta_title'){{ $data->meta_title }}@endsection
@section('meta_desc'){{ $data->meta_desc }}@endsection
@section('meta_keyw'){{ $data->meta_keyw }}@endsection
@section('content')
<main class="main-wrapper">
    <!-- Start Blog Area  -->
    <div class="axil-blog-area axil-section-gap">
        <div class="axil-single-post post-formate post-standard">
            <div class="container">
                <div class="content-block">
                    <div class="inner">
                        <div class="post-thumbnail">
                            <img src="/upload/blog/{{ $data->image }}" onerror="this.src='/extra/img/photo.png'" alt="{{ $data->blog_title }}">
                        </div>
                        <!-- End .thumbnail -->
                    </div>
                </div>
                <!-- End .content-blog -->
            </div>
        </div>
        <!-- End .single-post -->
        <div class="post-single-wrapper position-relative">
            <div class="container">
                <div class="row">
                    <div class="col-lg-1">
                        <div class="d-flex flex-wrap align-content-start h-100">
                            <div class="position-sticky sticky-top">
                                <div class="post-details__social-share">
                                    <span class="share-on-text">Paylaş:</span>
                                    <div class="social-share">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ env('APP_URL') }}/yazi/detay/{{ $data->blog_slug }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                        <a href="https://twitter.com/intent/tweet?text={{ env('APP_URL') }}/yazi/detay/{{ $data->blog_slug }}" target="_blank"><i class="fab fa-twitter"></i></a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ env('APP_URL') }}/yazi/detay/{{ $data->blog_slug }}"><i class="fab fa-linkedin-in"></i></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 axil-post-wrapper">
                        <div class="post-heading">
                            <h2 class="title">{{ $data->blog_title }}</h2>
                            <div class="axil-post-meta">
                                <div class="post-author-avatar">
                                    <img src="/extra/img/profile.png" alt="author softby">
                                </div>
                                <div class="post-meta-content">
                                    <h6 class="author-title">
                                        <a href="#">Yönetici</a>
                                    </h6>
                                    <ul class="post-meta-list">
                                        <li>{{ \Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</li>
                                        @if($data->blog_category != 0)
                                            <li>{{ $data->getCategory->category_title }}</li>
                                        @else
                                        <li>Kategori Bulunamadı!</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {!! $data->blog_desc !!}

                    </div>

                    <div class="col-lg-4">
                        <!-- Start Sidebar Area  -->
                        <aside class="axil-sidebar-area">

                            <!-- Start Single Widget  -->
                            <div class="axil-single-widget mt--40">
                                <h6 class="widget-title">Son Yazılar</h6>

                                @foreach (\App\Models\Blogs::orderBy('id','desc')->limit(5)->get() as $key)
                                <!-- Start Single Post List  -->
                                <div class="content-blog post-list-view mb--20">
                                    <div class="thumbnail">
                                        <a href="{{ route('blog_detail',$key->blog_slug) }}">
                                            <img src="/upload/blog/{{ $key->image }}" alt="{{ $key->blog_title }}">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h6 class="title"><a href="{{ route('blog_detail',$key->blog_slug) }}">{{ $key->blog_title }}</a></h6>
                                        <div class="axil-post-meta">
                                            <div class="post-meta-content">
                                                <ul class="post-meta-list">
                                                    <li>{{ \Carbon\Carbon::parse($key->created_at)->diffForHumans() }}</li>
                                                    @if($key->blog_category != 0)
                                                    <li>{{ $key->getCategory->category_title }}</li>
                                                    @else
                                                    <li>Kategori Bulunamadı!</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Post List  -->
                                @endforeach

                            </div>
                            <!-- End Single Widget  -->




                            <!-- Start Single Widget  -->
                            <div class="axil-single-widget mt--40 widget_archive">
                                <h6 class="widget-title">Kategoriler</h6>
                                <ul>
                                    @foreach (\App\Models\Blogcats::get() as $key)
                                        <li><a href="{{ route('blog_category_detail',$key->category_slug) }}">{{ $key->category_title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- End Single Widget  -->


                            <!-- Start Single Widget  -->
                            <div class="axil-single-widget mt--40 widget_tag_cloud">
                                <h6 class="widget-title">Anahtar Kelimeler</h6>
                                <div class="tagcloud">

                                    <a href="#" title="">{{$data->blog_tag}}</a>

                                </div>
                            </div>
                            <!-- End Single Widget  -->

                        </aside>
                        <!-- End Sidebar Area -->
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Blog Area  -->

    <!-- Start Related Blog Area  -->
    <div class="related-blog-area bg-color-white pb--60 pb_sm--40">
        <div class="container">
            <div class="section-title-wrapper mb--70 mb_sm--40 pr--110">
                <span class="title-highlighter highlighter-primary mb--10"> <i class="fal fa-bell"></i>Yakın zamanda</span>
                <h3 class="mb--25">Diğer Yazılarımız</h3>
            </div>
            <div class="related-blog-activation slick-layout-wrapper--15 axil-slick-arrow  arrow-top-slide">
                @foreach (\App\Models\Blogs::inRandomOrder()->get() as $key)
                <div class="slick-single-layout">
                    <div class="content-blog">
                        <div class="inner">
                            <div class="axil-gallery-activation axil-slick-arrow arrow-between-side">
                                <!-- Start Single Thumb  -->
                                <div class="thumbnail">
                                    <a href="{{ route('blog_detail',$key->blog_slug) }}">
                                        <img src="/upload/blog/{{ $key->image }}" alt="{{ $key->blog_title }}">
                                    </a>
                                </div>
                                <!-- End Single Thumb  -->
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="blog-details.html">{{ $key->blog_title }}</a></h5>
                                <div class="axil-post-meta">
                                    <div class="post-author-avatar">
                                        <img src="/extra/img/profile.png" alt="author softby">
                                    </div>
                                    <div class="post-meta-content">
                                        <h6 class="author-title">
                                            <a href="#">Yönetici</a>
                                        </h6>
                                        <ul class="post-meta-list">
                                            <li>{{ \Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</li>
                                            @if($data->blog_category != 0)
                                            <li>{{ $data->getCategory->category_title }}</li>
                                            @else
                                            <li>Kategori Bulunamadı!</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End Related Blog Area  -->


</main>

@endsection
