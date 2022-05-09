@extends('backend.layouts.master')

@section('title')
    Giỏ hàng
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
            <div class="col-12">
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-cart-plus"></i> Giỏ hàng
                                <small class="float-right">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-6 invoice-col">
                            Người bán
                            @foreach($items as $item)
                                <address>
                                    <strong>{{ \Illuminate\Support\Facades\Session::get('info_supplier')->name }}</strong><br>
                                    Địa chỉ: {{ \Illuminate\Support\Facades\Session::get('info_supplier')->address }}<br>
                                    Số điện thoại: {{ \Illuminate\Support\Facades\Session::get('info_supplier')->phone }}<br>
                                    Email: {{ \Illuminate\Support\Facades\Session::get('info_supplier')->email }}
                                </address>
                                @break
                            @endforeach
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6 invoice-col">
                            Người mua
                            <address>
                                <strong>Laptop88</strong><br>
                                Địa chỉ: Kinh Môn - Hải Dương<br>
                                Phone: 0966541655<br>
                                Email: tvt28051999@gmail.com
                            </address>
                        </div>
                        <!-- /.col -->
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive-sm" style="max-height: 100vh; overflow: auto;">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th id="nameor">Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td><a href="{{ route('backend.purchase.remove', $item->rowId) }}"><i class="fas fa-times text-danger"></i></a></td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <i class="fas fa-plus butt" onclick="increment('{{ $item->rowId }}')"></i>
                                            <span style="margin: 0 10px;">{{ $item->qty }}</span>
                                            @csrf
                                            <i class="fas fa-minus butt" onclick="decrement('{{ $item->rowId }}')"></i>
                                        </td>
                                        <td>{{ number_format($item->price, 0, '.', '.') }} ₫</td>
                                        <td>{{ number_format($item->price * $item->qty, 0, '.', '.') }} ₫</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-8 col-xl-9 col-xxl-9"></div>

                        <div class="col-12 col-sm-6 col-md-4 col-xl-3 col-xxl-3">
                            <div class="d-flex justify-content-between">
                                <div>Phí giao hàng:</div>
                                <div><b>Miễn phí</b></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>Tổng tiền:</div>
                                <div><b>{{ number_format(\Gloudemans\Shoppingcart\Facades\Cart::total(), 0, '.', '.') }} ₫</b></div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-12">
                            @if(\Gloudemans\Shoppingcart\Facades\Cart::count() > 0)
                                <form action="{{ route('backend.purchase.destroy.cart') }}" method="GET" id="deleteAll">
                                    <a href="" class="btn btn-sm btn-danger delete-confirm"><i class="fas fa-trash-alt"></i> Xóa giỏ hàng</a>
                                </form>
                            @endif

                            @if(\Gloudemans\Shoppingcart\Facades\Cart::count() > 0)
                                <form action="{{ route('backend.purchase.store') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm float-right">
                                        <i class="far fa-check-circle"></i> Đặt hàng
                                    </button>
                                </form>
                            @else
                                <b class="text-danger">Chưa có sản phẩm</b>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .butt{
            cursor: pointer;
        }
        .no-print>div{
            display: flex;
            justify-content: space-between;
        }
        @media screen and ( max-width: 520px ){
            .no-print>div{
                display: flex;
                justify-content: space-between;
            }
        }
        @media (min-width: 576px) and (max-width: 767px) {

            #nameor{
                width: 20%;
            }
        }
    </style>
    <script type="text/javascript">
        function increment(rowId){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ route('backend.purchase.increment') }}',
                method: 'POST',
                dataType: 'JSON',
                data: {rowId: rowId, _token: _token},
                success: function (data) {
                    location.reload();
                },
                error: function (){
                    swal("Thêm không thành công", "Vui lòng thử lại", "error");
                }
            });
        }

        function decrement(rowId){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ route('backend.purchase.decrement') }}',
                method: 'POST',
                dataType: 'JSON',
                data: {rowId: rowId, _token: _token},
                success: function (data) {
                    location.reload();
                },
                error: function (){
                    swal("Thêm không thành công", "Vui lòng thử lại", "error");

                }
            });
        }

        $('.delete-confirm').click(function(event) {
            event.preventDefault();
            swal({
                title: `Bạn có muốn xóa không?`,
                icon: "warning",
                buttons: ["Không", "Xóa"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#deleteAll').submit();
                    }
                });
        });
    </script>
@endsection
