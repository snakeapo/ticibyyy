@extends('page::frontend.layout.master')
@section('meta_title'){{ $data->meta_title }}@endsection
@section('meta_desc'){{ $data->meta_desc }}@endsection
@section('meta_keyw'){{ $data->meta_keyw }}@endsection
@section('content')
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home_index') }}">Anasayfa</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $data->page_title }}</li>
        </ol>
    </nav>
    <div class="container-fluid py-5 mb-2 mt-n2 mt-sm-1 my-md-3 my-lg-4 mb-xl-5">
    <div class="row justify-content-center">
        <div class="col-lg-11 col-xl-10 col-xxl-9">
            <h1 class="h2 pb-2 pb-sm-3 pb-lg-4">{{ $data->page_title }}</h1>
            <hr class="mt-0">

            <div class="h6 pt-2 pt-lg-3">
                <span class="text-body-secondary fw-medium">Son güncelleme:</span>
                {{ $data->updated_at }}
            </div>
            <p>{!! nl2br(e($data->page_desc)) !!}</p>

        </div>
    </div>
    </div>
@endsection
