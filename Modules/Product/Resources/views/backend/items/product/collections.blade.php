@extends('setting::backend.layout.default')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-head d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="page-main-title m-0">Koleksiyon Yönetimi</h4>
                    </div>
                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Kontrol Paneli</a></li>
                            <li class="breadcrumb-item active">Koleksiyonlar</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <livewire:admin.collection-manager />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
