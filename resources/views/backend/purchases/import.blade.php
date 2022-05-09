@extends('backend.layouts.master')

@section('title')
    Nhập hàng
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
        <form action="{{ route('backend.purchase.add') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xl-4">
                    <div class="card card-default" style="max-height: 80vh; overflow: auto;">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">
                                <i class="fas fa-home"></i>
                                Nhà cung cấp
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @foreach($suppliers as $supplier)
                                <div class="form-check" id="myform">
                                    @if(\Illuminate\Support\Facades\Session::has('info_supplier'))
                                    <input class="form-check-input sup" type="radio" name="supplier[]"
                                           id="flexRadioDefault1" value="{{ $supplier->id }}"
                                        {{ (\Gloudemans\Shoppingcart\Facades\Cart::count() > 0 && \Illuminate\Support\Facades\Session::get('info_supplier')->id == $supplier->id) ? 'checked' : 'disabled' }}>
                                    @else
                                        <input class="form-check-input sup" type="radio" name="supplier[]"
                                               id="flexRadioDefault1" value="{{ $supplier->id }}">
                                    @endif
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        {{ $supplier->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-xl-8">
                    <div class="card card-default" style="max-height: 80vh; overflow: auto;">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">
                                <i class="fas fa-bullhorn"></i>
                                Sản phẩm cung cấp
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên sản phẩm</th>
                                        <th id="qtyy">Số lượng</th>
                                        <th id="action"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="products">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        @media (min-width: 576px) and (max-width: 767px) {
            .quantity>input{
                width: 100%;
            }
            #action{
                width: 25%;
            }
        }
        @media (min-width: 768px) and (max-width: 991px) {
            .quantity>input{
                width: 100%;
            }
            #action{
                width: 25%;
            }
        }
        @media (min-width: 992px) and (max-width: 1199px) {
            .quantity>input{
                width: 100%;
            }
            #action{
                width: 25%;
            }
        }
        @media (min-width: 1200px) and (max-width: 1500px) {
            #action{
                width: 15%;
            }
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('body').on('click', '.addToCart', function(){
                var supplier = $("#myform input[name='supplier[]']:checked:enabled").val();
                var product_id = $(this).parent().data('id');
                var quantity = $(this).parent().prev().children('input').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ route('backend.purchase.add') }}',
                    method: 'POST',
                    dataType: 'JSON',
                    data: {product_id: product_id, supplier:supplier, quantity:quantity, _token: _token},
                    success: function (data) {
                        swal("Thêm thành công", "Xem chi tiết trong giỏ hàng", "success");
                        $('.sup').not($("#myform input[name='supplier[]']:checked:enabled")).attr('disabled', 'disabled');
                    },
                    error: function () {
                        swal("Thêm không thành công", "Lỗi", "error");
                    }
                });
            });

            $('.sup').click(function (){
                var id = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ route('backend.purchase.get.product') }}',
                    method: 'POST',
                    dataType: 'JSON',
                    data: {id: id, _token: _token},
                    success: function (data) {
                        $('#products').empty();
                        var i = 0;
                        $.each(data, function () {
                            $('#products').append(
                                '<tr>' +
                                    '<td>'+ i +'</td>' +
                                    '<td>'+ data[i].name +'</td>' +
                                    '<td class="quantity"><input type="number" min="1" name="quantity" autocomplete="off"></td>' +
                                    '<td data-id="'+ data[i].id +'"><button type="button" class="btn btn-sm btn-info addToCart">Đặt hàng</button></td>'+
                                '</tr>'
                            );
                            i++;
                        });
                    }
                });
            });
        });
    </script>
@endsection
