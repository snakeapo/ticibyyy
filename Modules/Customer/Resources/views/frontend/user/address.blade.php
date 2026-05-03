@extends('page::frontend.layout.master')
@section('content')
    <div class="container py-5 mt-n2 mt-sm-0">
        <div class="row pt-md-2 pt-lg-3 pb-sm-2 pb-md-3 pb-lg-4 pb-xl-5">


            <!-- Sidebar navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
            @include('customer::frontend.include.sidebar')
            <div class="modal fade" id="newAddressModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="newAddressModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newAddressModalLabel">Yeni adres kaydı</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="row g-3 g-lg-4" action="{{ route('new_address') }}" method="POST" novalidate>
                                @csrf
                                <div class="col-lg-6">
                                    <div class="position-relative">
                                        <label class="form-label">Adres başlığı</label>
                                        <input type="text" class="form-control" placeholder="Ev,Ofis.." name="address_title" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="position-relative">
                                        <label class="form-label">Telefon <small class="text-warning">(Başında 0 olmadan giriniz.)</small></label>
                                        <input type="number" class="form-control" name="phone" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="position-relative">
                                        <label class="form-label">İl</label>
                                        <input type="text" class="form-control" name="city" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="position-relative">
                                        <label class="form-label">İl</label>
                                        <input type="text" class="form-control" name="town" required>
                                     </div>
                                 </div>
                                <div class="col-lg-4">
                                    <div class="position-relative">
                                        <label for="add-zip" class="form-label">Posta kodu</label>
                                        <input type="text" class="form-control" name="postal_code">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="position-relative">
                                        <label for="add-address" class="form-label">Adres</label>
                                        <input type="text" class="form-control" name="address" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex gap-3 pt-2 pt-sm-0">
                                        <button type="submit" class="btn btn-primary">Kaydet</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Personal info content -->
            <div class="col-lg-9">
                <div class="ps-lg-3 ps-xl-0">

                    <!-- Page title -->
                    <h1 class="h5 mb-1 mb-sm-2">Adreslerim</h1>
                    @forelse($data as $take)


                    <!-- Primary shipping address -->
                    <div class="border-bottom py-4">
                        <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
                            <div class="d-flex align-items-center gap-3 me-4">
                                <h2 class="h6 mb-0">{{ $take->address_title }}</h2>
                                @if($loop->first)
                                    <span class="badge text-bg-info rounded-pill">Birincil</span>
                                @endif
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed" href="#primaryAddress{{ $take->id }}" data-bs-toggle="collapse" aria-expanded="false" aria-controls="primaryAddressPreview primaryAddressEdit">Düzenle</a>
                                <form action="{{ route('delete_address', $take->id) }}" method="POST" onsubmit="return confirm('Bu adresi silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link nav-link text-danger text-decoration-underline p-0">Sil</button>
                                </form>
                            </div>
                        </div>
                        <div class="collapse primary-address show" id="primaryAddressPreview">
                            <ul class="list-unstyled fs-sm m-0">
                                <li>{{ $take->town }} / {{ $take->city }}, {{ $take->postal_code }}</li>
                                <li>{{ $take->address }}</li>
                            </ul>
                        </div>
                        <div class="collapse primary-address" id="primaryAddress{{ $take->id }}">
                            <form class="row g-3 g-lg-4" action="{{ route('update_address',$take->id) }}" method="POST" novalidate>
                                @csrf
                                <div class="col-lg-6">
                                    <div class="position-relative">
                                        <label class="form-label">Adres başlığı</label>
                                        <input type="text" class="form-control" placeholder="Ev,Ofis.." value="{{ $take->address_title }}" name="address_title" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="position-relative">
                                        <label class="form-label">Telefon <small class="text-warning">(Başında 0 olmadan giriniz.)</small></label>
                                        <input type="number" class="form-control" value="{{ $take->phone }}" name="phone" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="position-relative">
                                        <label class="form-label">İl</label>
                                        <input type="text" class="form-control" value="{{ $take->city }}" name="city" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="position-relative">
                                        <label class="form-label">İl</label>
                                        <input type="text" class="form-control" value="{{ $take->town }}" name="town" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="position-relative">
                                        <label for="add-zip" class="form-label">Posta kodu</label>
                                        <input type="text" class="form-control" value="{{ $take->postal_code }}" name="postal_code">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="position-relative">
                                        <label for="add-address" class="form-label">Adres</label>
                                        <input type="text" class="form-control" value="{{ $take->address }}" name="address" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-3 pt-2 pt-sm-0">
                                        <button type="submit" class="btn btn-primary">Kaydet</button>
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#primaryAddress{{ $take->id }}" aria-expanded="true" aria-controls="primaryAddressPreview primaryAddressEdit">Vazgeç</button>
                                    </div>
                                </div>
                            </form>
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
                                Adres bulunamadı
                            </h5>

                            {{-- DESCRIPTION --}}
                            <p class="text-body-secondary mb-3 small">
                                Lütfen yeni bir adres oluşturup işlemlerinize devam ediniz.
                            </p>


                        </div>
                    @endforelse


                    <!-- Add address button -->
                    <div class="nav pt-4">
                        <a class="nav-link animate-underline fs-base px-0" href="#newAddressModal" data-bs-toggle="modal">
                            <i class="ci-plus fs-lg ms-n1 me-2"></i>
                            <span class="animate-target">Yeni adres ekle</span>
                        </a>
                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection
