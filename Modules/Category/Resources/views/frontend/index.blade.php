@extends('page::frontend.layout.master')

@section('content')
    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home_index') }}">Anasayfa</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kategoriler</li>
        </ol>
    </nav>


    <!-- Page title -->
    <h1 class="h3 container mb-sm-4">Tüm kategoriler</h1>




    <!-- Category cards -->
    <section class="container mb-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 gy-5">
            @foreach($categories as $category)

                <div class="col">
                    <div class="p-3 rounded-3 border h-100 hover-card">

                        {{-- TOP CATEGORY --}}
                        <h2 class="h6 fw-semibold mb-2">
                            <a class="text-dark text-decoration-none"
                               href="{{ route('top_category_detail',$category->category_slug) }}">
                                {{ $category->category_title }}
                            </a>
                        </h2>
                        <hr>
                        {{-- SUB --}}
                        <ul class="nav flex-column gap-1">

                            @foreach($category->subcategories as $sub)

                                <li>

                                    <a class="fs-sm text-dark text-decoration-none"
                                       href="{{ route('sub_parent_category_detail', [$category->category_slug,$sub->sub_slug]) }}">
                                        {{ $sub->sub_title }}
                                    </a>

                                    {{-- SUBSUB --}}
                                    @if($sub->children->count())
                                        <ul class="ms-2 mt-1">

                                            @foreach($sub->children as $child)
                                                <li>
                                                    <a class="fs-xs text-body-secondary text-decoration-none"
                                                       href="{{ route('sub_category_detail', [$category->category_slug,$sub->sub_slug,$child->sub_slug]) }}">
                                                        {{ $child->sub_title }}
                                                    </a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    @endif

                                </li>

                            @endforeach

                        </ul>

                    </div>
                </div>

            @endforeach
        </div>
    </section>
@endsection
