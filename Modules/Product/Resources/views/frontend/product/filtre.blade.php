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

    <button type="button" class="fixed-bottom z-sticky w-100 btn btn-lg btn-info border-0 border-top border-light border-opacity-10 rounded-0 pb-4 d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar" aria-controls="filterSidebar" data-bs-theme="light">
        <i class="ci-filter fs-base me-2"></i>
        Filtre
    </button>

@endsection
