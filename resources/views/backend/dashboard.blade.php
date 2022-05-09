@extends('backend.layouts.master')

@section('title')
    Trang chủ
@endsection

@section('script_top')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
@endsection

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $orders }}</h3>

                        <p>Đơn hàng</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('backend.order.index') }}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $countProducts }}</h3>

                        <p>Sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('backend.product.index') }}" class="small-box-footer">Xem thêm <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $users }}</h3>

                        <p>Người dùng</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('backend.user.index') }}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ number_format($profit, 0, '.', '.') }} </h3>

                        <p>Lợi nhuận</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('backend.statistic.index') }}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Doanh thu tháng {{ \Carbon\Carbon::now()->format('m') }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" id="minuss">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12 d-none">
                                    <label for="">Lọc theo</label>
                                    <select class="form-control form-control-sm filter-option">
                                        <option value="this_week">Tuần này</option>
                                        <option value="last_week">Tuần trước</option>
                                        <option value="this_month" selected>Tháng này</option>
                                        <option value="last_month">Tháng trước</option>
                                        <option value="this_year">Năm nay</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-12">
                                <div id="chart" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title">Sản phẩm mới nhập</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá nhập</th>
                                <th>Giá bán</th>
                                <th>Danh mục</th>
                                <th>Trạng thái</th>
                            </tr>
                            </thead>
                            <style>
                                td {
                                    vertical-align: middle !important;
                                }

                                .widspan {
                                    width: 90px;
                                    font-size: 14px;
                                    font-weight: normal;
                                }
                            </style>
                            <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach($products as $product)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ number_format($product->origin_price, 0, '.', '.') }}</td>
                                    <td>{{ number_format($product->sale_price, 0, '.', '.') }}</td>
                                    @if($product->category == null)
                                        <td>Không có</td>
                                    @else
                                    <td>{{ $product->category->name }}</td>
                                    @endif
                                    <td>
                                        @if($product->status == 0)
                                            <span
                                                class="badge badge-pill bg-warning widspan">{{ $product->status_text }}</span>
                                        @elseif($product->status == 1)
                                            <span
                                                class="badge badge-pill bg-success widspan">{{ $product->status_text }}</span>
                                        @else
                                            <span
                                                class="badge badge-pill bg-danger widspan">{{ $product->status_text }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
{{--                    <div style="margin: 0px auto; margin-top: 30px;">{!!$products->links()!!}</div>--}}
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            const formatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
                minimumFractionDigits: 0
            })

            //Thống kê doanh thu
            var chart = new Morris.Area({
                element: 'chart',
                lineColors: ['#819C79', '#fc8710', '#FF6541', '#A4ADD3', '#766B56'],
                pointFillColors: ['#ffffff'],
                pointStrokeColors: ['black'],
                fillOpacity: 0.6,
                hideHover: 'auto',
                parseTime: false,
                resize: true,
                xkey: 'period',
                ykeys: ['order', 'revenue', 'profit', 'quantity'],
                behaveLikeLine: true,
                labels: ['đơn hàng', 'doanh thu', 'lợi nhuận', 'sản phẩm'],
            });

            filter30day();

            function filter30day() {
                var filter_value = 'this_month';
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ route('backend.statistic.option') }}',
                    method: 'POST',
                    dataType: 'JSON',
                    data: {filter_value: filter_value, _token: _token},
                    success: function (data) {
                        chart.setData(data);
                    },
                    error: function () {
                        $('#minuss').click();
                    }
                });
            }
        });
    </script>
@endsection
