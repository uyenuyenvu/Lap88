@extends('backend.layouts.master')

@section('title')
    Danh sách đơn hàng
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
        <!-- Main row -->
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Đơn hàng</h3>
                        <div class="card-tools d-flex">
                            <select class="form-select form-select-sm" aria-label="Default select example"
                                    name="status" style="margin-right: 10px;" onchange="location = this.value;">
                                <option>Trạng thái</option>
                                @foreach(\App\Models\Purchase::$status_text as $key => $value)
                                    <option
                                        value="{{ request()->fullUrlWithQuery(['status' => $key]) }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <form action="{{ route('backend.purchase.order') }}" method="GET">
                                <div class="input-group input-group-sm" style="width: 150px; margin-top: 0;">
                                    <input type="text" name="q" class="form-control float-right"
                                           placeholder="Tìm kiếm" value="{{ (isset($q)? $q : '') }}">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên nhà cung cấp</th>
                                <th>Số điện thoại</th>
                                <th>Tổng đơn hàng</th>
                                <th>Thời gian tạo</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                            </thead>
                            <style>
                                .widspan {
                                    padding: .25em 10px;
                                    font-size: 14px;
                                }
                            </style>
                            <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach($orders as $order)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->phone }}</td>
                                    <td>{{ number_format($order->total_price, 0, '.', '.') }} ₫</td>
                                    <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                                    @if($order->status == 0)
                                        <td><span class="badge badge-pill bg-danger widspan font-weight-normal">{{ $order->status_text }}</span></td>
                                    @elseif($order->status == 1)
                                        <td><span class="badge badge-pill bg-success widspan font-weight-normal">{{ $order->status_text }}</span></td>
                                    @else
                                        <td><span class="badge badge-pill bg-secondary widspan font-weight-normal">{{ $order->status_text }}</span></td>
                                    @endif
                                    <td class="project-actions text-right" id="detail">
                                        <form action="{{ route('backend.purchase.update', $order->id) }}" method="POST"
                                              class="d-inline-block" class="update_status">
                                            {{ csrf_field() }}
                                            {{ method_field('PUT') }}

                                            <div class="btn-group" role="group"
                                                 aria-label="Button group with nested dropdown">
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupDrop1" type="button"
                                                            class="btn btn-warning btn-sm dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"
                                                        {{ ($order->status !== 0) ? 'disabled' : '' }}>
                                                        <i class="fas fa-layer-group"></i> Xử lý
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        @foreach(\App\Models\Purchase::$status_text as $key => $val)
                                                            @if($key > 0)
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
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('backend.purchase.show', $order->id) }}">
                                            <i class="fas fa-eye"></i> Chi tiết
                                        </a>
{{--                                        <form action="{{ route('backend.purchase.destroy', $order->id) }}"--}}
{{--                                              method="POST" style="display: inline">--}}
{{--                                            {{ csrf_field() }}--}}
{{--                                            {{ method_field('DELETE') }}--}}

{{--                                            <button type="submit" class="btn btn-danger btn-sm delete-confirm"--}}
{{--                                                {{ ($order->status == 1) ? 'disabled' : '' }}>--}}
{{--                                                <i class="fas fa-eraser"></i> Xóa--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">

                        </div>
                        <div class="col-6">
                            <div class="float-right mr-4">{!! $orders->appends(request()->input())->links() !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(Session::has('success'))
        <script>
            toastr.success("{!! Session::get('success') !!}");
        </script>
    @elseif(Session::has('error'))
        <script>
            toastr.error("{!! Session::get('error') !!}");
        </script>
    @endif

    <script>
        $('.delete-confirm').click(function (event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: `Bạn có muốn xóa không?`,
                text: "Nếu bạn xóa nó, bạn sẽ không thể khôi phục lại được",
                icon: "warning",
                buttons: ["Không", "Xóa"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });

        $(document).ready(function () {
            $('.option_handling').click(function () {
                $(this).children('input').attr('name', 'status');
                $(this).parentsUntil('.update_status').submit();
            });
        });
    </script>
@endsection

@section('script-bot')
    <style>
        .widspan {
            padding: .25em 10px;
            font-size: 14px;
        }
    </style>
@endsection
