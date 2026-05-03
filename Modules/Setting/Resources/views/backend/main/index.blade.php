@extends('setting::backend.layout.default')
@section('content')


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="page-title-head d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="page-main-title m-0">Gösterge</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Başlangıç</a></li>
                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Gösterge paneli</a></li>
                    </ol>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xxl-3 col-sm-6">
                    <div class="card widget-flat text-bg-pink">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-eye-line widget-icon"></i>
                            </div>
                            <h6 class="text-uppercase mt-0" title="Customers">Toplam Görüntüleme</h6>
                            <h2 class="my-2">{{ \App\Models\Pasts::count() }}</h2>
                            <p class="mb-0">
                                <span class="text-nowrap">Tüm zamanlar için</span>
                            </p>
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-xxl-3 col-sm-6">
                    <div class="card widget-flat text-bg-purple">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-wallet-2-line widget-icon"></i>
                            </div>
                            <h6 class="text-uppercase mt-0" title="Customers">Kazanç</h6>
                            <h2 class="my-2">{{ number_format(\App\Models\Orders::sum('total'),2) }} TL</h2>
                            <p class="mb-0">
                                <span class="text-nowrap">Tüm zamanlar için geçerli</span>
                            </p>
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-xxl-3 col-sm-6">
                    <div class="card widget-flat text-bg-info">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-shopping-basket-line widget-icon"></i>
                            </div>
                            <h6 class="text-uppercase mt-0" title="Customers">Sipariş</h6>
                            <h2 class="my-2">{{ \App\Models\Orders::count() }}</h2>
                            <p class="mb-0">
                                <span class="text-nowrap">Bugüne kadar toplam</span>
                            </p>
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-xxl-3 col-sm-6">
                    <div class="card widget-flat text-bg-primary">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-group-2-line widget-icon"></i>
                            </div>
                            <h6 class="text-uppercase mt-0" title="Customers">Müşteri</h6>
                            <h2 class="my-2">{{ \App\Models\User::where('role','user')->count() }}</h2>
                            <p class="mb-0">
                                <span class="text-nowrap">{{ \App\Models\User::where('sex','female')->where('role','user')->count() }} Kadın - {{ \App\Models\User::where('sex','male')->where('role','user')->count() }} Erkek</span>

                            </p>
                        </div>
                    </div>
                </div> <!-- end col-->
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">

                            <h5 class="header-title mb-0">Bu Ayki Toplam Kazanç</h5>

                            <div id="weeklysales-collapse" class="collapse pt-3 show">
                                <div dir="ltr">
                                    <div>
                                        <canvas id="myBarChart" ></canvas>

                                    </div>

                                </div>

                                <div class="row text-center">
                                    <div class="col">
                                        <p class="text-muted mt-3">Toplam</p>
                                        <h3 class=" mb-0">
                                            <span>{{ number_format($toplam_tutar,2)}} TL</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">

                            <h5 class="header-title mb-0">Bu Ay ki Toplam Sipariş</h5>

                            <div id="yearly-sales-collapse" class="collapse pt-3 show">
                                <div dir="ltr">
                                    <canvas id="myBarCharts" ></canvas>
                                </div>
                                <div class="row text-center">
                                    <div class="col">
                                        <p class="text-muted mt-3 mb-2">Toplam</p>
                                        <h4 class="mb-0">{{ $toplam_siparis }} Adet</h4>
                                    </div>

                                </div>
                            </div>

                        </div> <!-- end card-body-->
                    </div> <!-- end card-->


                </div> <!-- end col-->

            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-xl-4">
                    <!-- Chat-->
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="p-3">

                                <h5 class="header-title mb-0">Soru & Cevap</h5>
                            </div>

                            <div id="yearly-sales-collapse" class="collapse show">
                                <div class="chat-conversation mt-2">
                                    <div class="card-body py-0 mb-3" data-simplebar style="height: 322px;">
                                        <ul class="conversation-list">
                                           @if(\App\Models\Askques::where('status',0)->count() != 0)
                                            @foreach (\App\Models\Askques::orderBy('id','desc')->where('status',0)->limit('1')->get() as $key)

                                            <li class="clearfix">
                                                <div class="chat-avatar">
                                                    <img src="/upload/user/{{ $key->getUser->avatar }}" alt="">
                                                    <i>{{ \Carbon\Carbon::parse($key->created_at)->format('h:i') }}</i>
                                                </div>
                                                <div class="conversation-text">
                                                    <div class="ctext-wrap">
                                                        <i>{{ $key->getUser->name }}</i>
                                                        <p>
                                                            {{ $key->ask }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>

                                            @endforeach
                                            @else
                                            <div class="text-center mt-5">
                                                <img src="/extra/img/no-result.png" class="img-fluid" width="100" alt="">
                                                <h5>Soru Bulunamadı</h5>
                                            </div>
                                            @endif


                                        </ul>
                                    </div>
                                    @if(\App\Models\Askques::where('status',0)->count() != 0)
                                    @foreach (\App\Models\Askques::orderBy('id','desc')->where('status',0)->limit('1')->get() as $key)
                                    @if($key->answer == null)
                                    <div class="card-body pt-0">
                                        <form class="needs-validation" action="{{ route('question_answer',$key->id) }}" method="POST" id="chat-form">
                                            @csrf
                                            <div class="row align-items-start">
                                                <div class="col">
                                                    <input type="text" name="answer" class="form-control chat-input" placeholder="Lütfen bir cevap yazın" required>

                                                </div>
                                                <div class="col-auto d-grid">
                                                    <button type="submit" class="btn btn-danger chat-send waves-effect waves-light">Gönder</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    @endif
                                    @endforeach
                                    @endif
                                </div> <!-- end .chat-conversation-->
                            </div>
                        </div>

                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-xl-8">
                    <!-- Todo-->
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="p-3">

                                <h5 class="header-title mb-0">Son Siparişler</h5>
                            </div>

                            <div id="yearly-sales-collapse" class="collapse show">

                                <div class="table-responsive p-3">
                                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#No</th>
                                                <th>Sipariş Tarihi</th>
                                                <th>Müşteri Email</th>
                                                <th>Müşteri Ad Soyad</th>
                                                <th>Ürün</th>
                                                <th>Toplam</th>
                                                <th>Detay</th>
                                                <th>Fatura</th>
                                                <th>Sil</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (\App\Models\Orders::where('status',0)->limit(5)->get() as $key)
                                            <tr>
                                                <td>#{{ $key->order_no }}</td>
                                                <td>{{ $key->created_at }}</td>
                                                <td>{{ $key->getUser->email }}</td>
                                                <td>{{ $key->getUser->name }} {{ $key->getUser->surname }}</td>
                                                <td>{{ \App\Models\Orderitems::where('order_token',$key->order_no)->count()  }} Adet Ürün</td>
                                                <td>{{ number_format($key->total,2) }} TL</td>


                                                <td><a href="{{ route('order_detail',$key->id) }}" class="btn btn-primary">Detay</a></td>
                                                <td><a href="{{ route('invoice',$key->order_no) }}" target="_blank" class="btn btn-pink">Fatura</a></td>
                                                <td><a href="{{ route('order_delete',$key->id) }}" onclick="confirmation(event)" class="btn btn-danger">Sil</a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>
            <!-- end row -->

        </div>
        <!-- container -->

@endsection

@push('page-scripts')
<script src="{{ asset('panel/assets/js/pages/custom-table.js') }}"></script>
<script src="{{ asset('panel/assets/js/pages/dashboard.js') }}"></script>
@endpush
