@extends('page::frontend.layout.master')
@section('content')
    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home_index') }}">Anasayfa</a></li>
            <li class="breadcrumb-item active" aria-current="page">Koleksiyonlar</li>
        </ol>
    </nav>
    <div class="container pb-5">
        <!-- Grid of cards -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-4">
            @forelse($data as $take)
                <!-- Card -->
                <div class="col">
                    <div class="card">
                        <p class="card-header fs-md">{{ $take->title }}</p>
                        <div class="card-body">
                             <span class="row row-cols-3 row-cols-sm-3 row-cols-md-6 g-4">
                                 @foreach(\App\Models\Collection_product::where('collection_id',$take->id)->get() as $key)
                                    <div class="col">
                                     <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $key->getProduct->title}}" href="{{ route('product_detail', $key->getProduct->slug . '-' . $key->getProduct->product_token) }}"><span><img src="{{ asset('upload/product/'.$key->getProduct->image) }}" width="64" alt="Thumbnail"></span></a>

                                    </div>
                                 @endforeach

                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 mx-auto">

                    {{-- SVG ICON --}}
                    <div class="mb-3">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.5776 14.5419C15.5805 13.53 16.2 12.1373 16.2 10.6C16.2 7.50721 13.6928 5 10.6 5C7.50721 5 5 7.50721 5 10.6C5 13.6928 7.50721 16.2 10.6 16.2C12.1555 16.2 13.5628 15.5658 14.5776 14.5419ZM14.5776 14.5419L19 19M8.5 8.5L12.5 12.5M12.5 8.5L8.5 12.5" stroke="#464455" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    {{-- TITLE --}}
                    <h5 class="mb-2 fw-semibold">
                        Koleksiyon bulunamadı
                    </h5>

                    {{-- DESCRIPTION --}}
                    <p class="text-body-secondary mb-3 small">
                        Şuan oluşturulmuş hiç koleksiyon bulunamadı.
                    </p>


                </div>
            @endforelse


        </div>
        <div class="row row-cols-2 row-cols-md-3 g-4 p-3">

        </div>
    </div>
    @section('js')
        <script>
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        </script>
    @endsection
@endsection
