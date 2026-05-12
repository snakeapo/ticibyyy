@extends('page::frontend.layout.master')

@section('content')
    <style>
        @media (min-width: 992px) {
            #filterSidebar {
                transform: none !important;
                visibility: visible !important;
                position: static !important;
            }
            .offcanvas-backdrop {
                display: none !important;
            }
            .offcanvas-backdrop.show {
                opacity: 0 !important;
                visibility: hidden !important;
            }
        }
    </style>
    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home_index') }}">Anasayfa</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ürünler</li>
        </ol>
    </nav>



            <livewire:frontend.product-filter-page
                :category="$category"
                :subcategory="$subcategory"
                :child-category="$childCategory"
                :brand="$brand"
                :q="$q"
            />



@endsection
