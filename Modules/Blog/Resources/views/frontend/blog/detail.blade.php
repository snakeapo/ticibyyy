@extends('page::frontend.layout.master')
@section('meta_title'){{ $data->meta_title }}@endsection
@section('meta_desc'){{ $data->meta_desc }}@endsection
@section('meta_keyw'){{ $data->meta_keyw }}@endsection
@section('content')
    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home_index') }}">Anasayfa</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $data->blog_title }}</li>
        </ol>
    </nav>


    <!-- Post content + Sidebar -->
    <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
        <div class="row">

            <!-- Posts content -->
            <div class="col-lg-8 position-relative z-2">

                <!-- Post title -->
                <h1 class="h3 mb-4">{{ $data->blog_title }}</h1>

                <!-- Post meta -->
                <div class="nav align-items-center gap-2 border-bottom pb-4 mt-n1 mb-4">
                    <a class="nav-link text-body fs-xs text-uppercase p-0" href="#!">{{ $data->getCategory->category_title }}</a>
                    <hr class="vr my-1 mx-1">
                    <span class="text-body-tertiary fs-xs">{{ \Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</span>
                </div>

                <figure class="figure w-100 py-3 py-md-4 mb-3">
                    <div class="ratio" style="--cz-aspect-ratio: calc(599 / 856 * 100%)">
                        <img src="{{ asset('/upload/blog/'.$data->image) }}" class="rounded-4" alt="{{$data->blog_slug}}">
                    </div>
                </figure>
                <p>{!! nl2br(e($data->blog_desc)) !!}</p>


                <!-- Tags + Sharing -->
                <div class="d-sm-flex align-items-center justify-content-between py-4 py-md-5 mt-n2 mt-md-n3 mb-2 mb-sm-3 mb-md-0">

                    <div class="d-flex flex-wrap gap-2 mb-4 mb-sm-0 me-sm-4">

                        @php
                            $tags = explode(',', $data->blog_tag);
                        @endphp

                        @foreach($tags as $tag)

                            <a class="btn btn-outline-secondary px-3 mt-1 me-1"
                               href="#!">

                                {{ trim($tag) }}

                            </a>

                        @endforeach

                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="text-body-emphasis fs-sm fw-medium">Paylaş:</div>
                        <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="https://twitter.com/intent/tweet?text={{ env('APP_URL') }}/yazi/detay/{{ $data->blog_slug }}" data-bs-toggle="tooltip" data-bs-template="&lt;div class=&quot;tooltip fs-xs mb-n2&quot; role=&quot;tooltip&quot;&gt;&lt;div class=&quot;tooltip-inner bg-transparent text-body p-0&quot;&gt;&lt;/div&gt;&lt;/div&gt;" aria-label="Follow us on X" data-bs-original-title="X (Twitter)">
                            <i class="ci-x"></i>
                        </a>
                        <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="https://www.facebook.com/sharer/sharer.php?u={{ env('APP_URL') }}/yazi/detay/{{ $data->blog_slug }}" data-bs-toggle="tooltip" data-bs-template="&lt;div class=&quot;tooltip fs-xs mb-n2&quot; role=&quot;tooltip&quot;&gt;&lt;div class=&quot;tooltip-inner bg-transparent text-body p-0&quot;&gt;&lt;/div&gt;&lt;/div&gt;" aria-label="Follow us on Facebook" data-bs-original-title="Facebook">
                            <i class="ci-facebook"></i>
                        </a>
                        <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="https://www.linkedin.com/shareArticle?mini=true&url={{ env('APP_URL') }}/yazi/detay/{{ $data->blog_slug }}" data-bs-toggle="tooltip" data-bs-template="&lt;div class=&quot;tooltip fs-xs mb-n2&quot; role=&quot;tooltip&quot;&gt;&lt;div class=&quot;tooltip-inner bg-transparent text-body p-0&quot;&gt;&lt;/div&gt;&lt;/div&gt;" aria-label="Follow us on Telegram" data-bs-original-title="Telegram">
                            <i class="ci-linkedin"></i>
                        </a>
                    </div>
                </div>



            </div>


            <aside class="col-lg-4 col-xl-3 offset-xl-1" style="margin-top: -115px">
                <div class="offcanvas-lg offcanvas-end sticky-lg-top ps-lg-4 ps-xl-0" id="blogSidebar">
                    <div class="d-none d-lg-block" style="height: 115px"></div>
                    <div class="offcanvas-header py-3">
                        <h5 class="offcanvas-title">Sidebar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#blogSidebar" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-block pt-2 py-lg-0">
                        <h4 class="h6 mb-4">Diğer kategoriler</h4>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach (\App\Models\Blogcats::get() as $key)
                                <a class="btn btn-outline-secondary px-3" href="{{ route('blog_category_detail',$key->category_slug) }}">{{ $key->category_title }}</a>
                            @endforeach

                        </div>

                        <h4 class="h6 pt-4">Sosyal medya</h4>
                        <div class="d-flex gap-2 pb-2">
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="{{ $setting->instagram }}" data-bs-toggle="tooltip" data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>' title="Instagram" aria-label="Follow us on Instagram">
                                <i class="ci-instagram"></i>
                            </a>
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="{{ $setting->twitter }}" data-bs-toggle="tooltip" data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>' title="X (Twitter)" aria-label="Follow us on X">
                                <i class="ci-x"></i>
                            </a>
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="{{ $setting->facebook }}" data-bs-toggle="tooltip" data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>' title="Facebook" aria-label="Follow us on Facebook">
                                <i class="ci-facebook"></i>
                            </a>
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="{{ $setting->youtube }}" data-bs-toggle="tooltip" data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>' title="Telegram" aria-label="Follow us on Telegram">
                                <i class="ci-youtube"></i>
                            </a>
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="{{ $setting->linkedin }}" data-bs-toggle="tooltip" data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>' title="Telegram" aria-label="Follow us on Telegram">
                                <i class="ci-linkedin"></i>
                            </a>
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="{{ $setting->pinterest }}" data-bs-toggle="tooltip" data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>' title="Telegram" aria-label="Follow us on Telegram">
                                <i class="ci-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
