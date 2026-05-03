@extends('page::frontend.layout.master')
@section('meta_title'){{ $category->meta_title }}@endsection
@section('meta_desc'){{ $category->meta_desc }}@endsection
@section('meta_keyw'){{ $category->meta_keyw }}@endsection
@section('content')
<main class="main-wrapper">
    <!-- Start Breadcrumb Area  -->
    <div class="axil-breadcrumb-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8">
                    <div class="inner">
                        <ul class="axil-breadcrumb">
                            <li class="axil-breadcrumb-item"><a href="{{ route('home_index') }}">Anasayfa</a></li>
                            <li class="separator"></li>
                            <li class="axil-breadcrumb-item active" aria-current="page">Yazılar</li>
                        </ul>
                        <h1 class="title">{{ $category->category_title }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area  -->
    <!-- Start Blog Area  -->
    <div class="axil-blog-area axil-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row g-5">
                        @if($data->count() != 0)
                        @foreach ($data as $key)
                        <div class="col-md-6">
                            <div class="content-blog blog-grid">
                                <div class="inner">
                                    <div class="thumbnail">
                                        <a href="{{ route('blog_detail',$key->blog_slug) }}">
                                            <img src="/upload/blog/{{ $key->image }}" onerror="this.src='/extra/img/photo.png'" alt="{{ $key->blog_title }}">
                                        </a>
                                        <div class="blog-category">
                                            @if ($key->blog_category != 0)
                                            <a href="{{ route('blog_category_detail',$key->getCategory->category_title) }}">{{ $key->getCategory->category_title }}</a>
                                            @else
                                            <a href="#">Kategori Bulunamadı!</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h5 class="title"><a href="{{ route('blog_detail',$key->blog_slug) }}">{{ $key->blog_title }}</a></h5>
                                        <div class="read-more-btn">
                                            <a class="axil-btn right-icon" href="{{ route('blog_detail',$key->blog_slug) }}">Yazıyı Oku <i class="fal fa-long-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="text-center">
                            <img src="/extra/img/no-result.png" class="img-fluid" width="100" alt="">
                            <h5>Sonuç Bulunamadı!</h5>
                        </div>
                        @endif
                    </div>
                    <div class="post-pagination">
                        <nav class="navigation pagination" aria-label="Products">
                            <ul class="page-numbers">
                               {{ $data->links('pagination::default') }}
                            </ul>
                        </nav>
                    </div>
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
                                @foreach ($data as $key)
                                <a href="#" title="">{{$key->blog_tag}}</a>
                                @endforeach
                            </div>
                        </div>
                        <!-- End Single Widget  -->

                    </aside>
                    <!-- End Sidebar Area -->
                </div>
            </div>
            <!-- End post-pagination -->
        </div>
        <!-- End .container -->
    </div>
    <!-- End Blog Area  -->

</main>
@endsection
