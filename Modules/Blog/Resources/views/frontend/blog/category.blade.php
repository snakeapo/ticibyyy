@extends('page::frontend.layout.master')
@section('meta_title'){{ $category->meta_title }}@endsection
@section('meta_desc'){{ $category->meta_desc }}@endsection
@section('meta_keyw'){{ $category->meta_keyw }}@endsection
@section('content')
    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home_index') }}">Anasayfa</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->category_title }}</li>
        </ol>
    </nav>


    <!-- Page title -->
    <h1 class="h3 container mb-4">{{ $category->category_title }}</h1>


    @if(request()->get('page', 1) == 1 && $featuredPost)

        <section class="container pb-5">
            <div class="row gy-5 pb-5">

                {{-- Büyük post --}}
                <article class="col-md-6 col-lg-7">

                    <a class="ratio d-flex hover-effect-scale rounded-4 overflow-hidden"
                       href="{{ route('blog_detail', $featuredPost->blog_slug) }}"
                       style="--cz-aspect-ratio: calc(484 / 746 * 100%)">

                        <img src="{{ asset('/upload/blog/'.$featuredPost->image) }}"
                             class="hover-effect-target"
                             alt="{{ $featuredPost->blog_title }}">
                    </a>

                    <div class="pt-4">

                        <div class="nav align-items-center gap-2 pb-2 mt-n1 mb-1">

                    <span class="text-body-tertiary fs-xs">
                        {{ $featuredPost->created_at->format('d M Y') }}
                    </span>

                        </div>

                        <h3 class="h5 mb-0">
                            <a class="hover-effect-underline"
                               href="{{ route('blog_detail', $featuredPost->blog_slug) }}">

                                {{ $featuredPost->blog_title }}

                            </a>
                        </h3>

                    </div>

                </article>


                {{-- Sağdaki 3 post --}}
                <div class="col-md-6 col-lg-5 d-flex flex-column align-content-between gap-4">

                    @foreach($sidePosts as $post)

                        <article class="hover-effect-scale position-relative d-flex align-items-center ps-xl-4 mb-xl-1">

                            <div class="w-100 pe-3 pe-sm-4 pe-lg-3 pe-xl-4">

                                <div class="text-body-tertiary fs-xs pb-2 mb-1">
                                    {{ $post->created_at->format('d M Y') }}
                                </div>

                                <h3 class="h6 mb-2">

                                    <a class="hover-effect-underline stretched-link"
                                       href="{{ route('blog_detail', $post->blog_slug) }}">

                                        {{ $post->blog_title }}

                                    </a>

                                </h3>

                            </div>

                            <div class="ratio w-100 rounded overflow-hidden"
                                 style="max-width: 196px; --cz-aspect-ratio: calc(140 / 196 * 100%)">

                                <img src="{{ asset('/upload/blog/'.$post->image) }}"
                                     class="hover-effect-target"
                                     alt="{{ $post->blog_title }}">

                            </div>

                        </article>

                    @endforeach

                </div>

            </div>

            <hr class="my-0 my-md-2 my-lg-4">

        </section>

    @endif


    <!-- Posts grid + Sidebar -->
    <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
        <div class="row">


            <div class="col-lg-8">

                <div class="row row-cols-1 row-cols-sm-2 gy-5">

                    @foreach($blogs as $post)

                        <article class="col">

                            <a class="ratio d-flex hover-effect-scale rounded overflow-hidden"
                               href="{{ route('blog_detail', $post->blog_slug) }}"
                               style="--cz-aspect-ratio: calc(305 / 416 * 100%)">

                                <img src="{{ asset('/upload/blog/'.$post->image) }}"
                                     class="hover-effect-target"
                                     alt="{{ $post->blog_title }}">

                            </a>

                            <div class="pt-4">

                                <div class="nav align-items-center gap-2 pb-2 mt-n1 mb-1">

                                <span class="text-body-tertiary fs-xs">
                                    {{ $post->created_at->format('d M Y') }}
                                </span>

                                </div>

                                <h3 class="h5 mb-0">

                                    <a class="hover-effect-underline"
                                       href="{{ route('blog_detail', $post->blog_slug) }}">

                                        {{ $post->blog_title }}

                                    </a>

                                </h3>

                            </div>

                        </article>

                    @endforeach

                </div>
                @if($blogs->count() != 0)
                <hr class="mt-4 mt-sm-5">
                @endif
                {{ $blogs->links() }}

            </div>


            <!-- Sticky sidebar that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
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
