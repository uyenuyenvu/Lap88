@extends('backend.layouts.master')

@section('title')
    Chi tiết đơn hàng
@endsection

@section('script_top')
    <link rel="stylesheet" href="/backend/dist/css/respon.css">
@endsection

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
        </div><!-- /.row -->
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $order->name }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-envelope"></i> Email</strong>

                        <p class="text-muted">
                            {{ $order->user->email }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-mobile-alt"></i> Số điện thoại</strong>

                        <p class="text-muted">
                            {{ $order->phone }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Địa chỉ giao hàng</strong>

                        <p class="text-muted">
                            {{ $order->address }}
                        </p>

                        <hr>

                        <strong><i class="far fa-sticky-note mr-1"></i> Lưu ý khi giao hàng</strong>
                        @if(!empty($order->note))
                            <p class="text-muted">
                                {{ $order->note }}
                            </p>
                        @else
                            <p class="text-muted">
                                Không có
                            </p>
                        @endif

                        <hr>

                        <strong><i class="fas fa-clock"></i> Thời gian tạo</strong>

                        <p class="text-muted">
                            {{ $order->created_at }}
                        </p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#product"
                                                    data-toggle="tab">Chi tiết đơn hàng</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="product">
                                <div class="card-body table-responsive p-0" style="max-height: 70vh; overflow: auto;">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr class="bg-primary">
                                            <th>STT</th>
                                            <th id="proname">Tên sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Đơn giá</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <style>
                                            td {
                                                vertical-align: middle !important;
                                            }

                                            .widspan {
                                                width: 90px;
                                                font-size: 14px;
                                                font-weight: normal;
                                                color: white !important;
                                            }
                                        </style>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach($order->products as $item)
                                            @php
                                                $i++;
                                            @endphp
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->name }}</td>
                                                @if($item->quantity == 0)
                                                    <td class="text-danger">Hết hàng</td>
                                                @else
                                                <td>{{ $item->pivot->quantity }}</td>
                                                @endif
                                                <td>{{ number_format($item->pivot->price, 0, '.', '.') }} ₫</td>
                                                <td>{{ number_format($item->pivot->price * $item->pivot->quantity, 0, '.', '.') }}
                                                    ₫
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-xl-8">
                                        <p><b class="text-primary">Tổng thanh toán:</b> <span>{{ number_format($order->total_price, 0, '.', '.') }} ₫</span>
                                        </p>
                                    </div>

                                    @if($order->status < 3 && $item->quantity > 0)
                                        <div class="col-12 col-sm-6 col-md-6 col-xl-4">
                                            <form action="{{ route('backend.order.update', $order->id) }}" method="POST" id="update_status" class="float-sm-right">
                                                {{ csrf_field() }}
                                                {{ method_field('PUT') }}

                                                <div class="btn-group" role="group"
                                                     aria-label="Button group with nested dropdown">
                                                    <div class="btn-group" role="group">
                                                        <button id="btnGroupDrop1" type="button"
                                                                class="btn btn-warning btn-sm dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                            {{ ($order->status == 3) ? 'disabled' : '' }}>
                                                            <i class="fas fa-layer-group"></i> Xử lý
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                            @if($order->status == 0)
                                                                <li class="option_handling">
                                                                    <span class="dropdown-item" href="#"
                                                                          style="cursor: pointer;">Đã xác nhận</span>
                                                                    <input type="hidden" value="1" name="">
                                                                </li>
                                                            @endif
                                                            @foreach(\App\Models\Order::$status_text as $key => $val)
                                                                @if($order->status > 0 && $order->status < $key)
                                                                    <li class="option_handling">
                                                                    <span class="dropdown-item" href="#"
                                                                          style="cursor: pointer;">{{ $val }}</span>
                                                                        <input type="hidden" value="{{ $key }}" name="">
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @elseif($item->quantity == 0)
                                        <div class="col-12 col-sm-6 col-md-6 col-xl-4">
                                            <p class="text-sm-right text-danger font-weight-bold">Không đủ sản phẩm</p>
                                        </div>
                                    @elseif($order->status == 3)
                                        <div class="col-12 col-sm-6 col-md-6 col-xl-4">
                                            <p class="text-sm-right text-danger font-weight-bold">Đã hủy</p>
                                        </div>
                                    @elseif($order->status == 4)
                                        <div class="col-12 col-sm-6 col-md-6 col-xl-4">
                                            <p class="text-sm-right text-danger font-weight-bold">Đã hoàn thành</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <style>
        @media (min-width: 576px) and (max-width: 767px){
            #proname{
                width: 25%;
            }
        }
    </style>
    <script>
        $(document).ready(function () {
            $('.option_handling').click(function () {
                $(this).children('input').attr('name', 'status');
                $('#update_status').submit();
            });
        });
    </script>
@endsection
