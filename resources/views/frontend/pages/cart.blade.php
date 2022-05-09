@extends('frontend.layouts.master')

@section('title')
    Giỏ hàng
@endsection

@section('content')
    <section class="heading-banner-area pt-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-banner">
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="index.html">Trang chủ</a><span class="breadcome-separator">></span></li>
                                <li>Giỏ hàng</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Heading Banner Area End-->
    <!--Shopping Cart Area Start-->
    <div class="shopping-cart-area mt-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form class="shop-form" action="#">
                        <div class="wishlist-table table-responsive">
                            <table>
                                <thead>
                                <tr>
                                    <th class="product-remove"></th>
                                    <th class="product-cart-img">
                                        <span class="nobr">Ảnh mô tả</span>
                                    </th>
                                    <th class="product-name">
                                        <span class="nobr">Tên sản phẩm</span>
                                    </th>
                                    <th class="product-quantity">
                                        <span class="nobr">Số lượng</span>
                                    </th>
                                    <th class="product-price">
                                        <span class="nobr">Đơn giá</span>
                                    </th>
                                    <th class="product-total-price">
                                        <span class="nobr">Thành tiền</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td class="product-remove">
                                            <a href="{{ route('frontend.cart.remove', $item->rowId) }}">×</a>
                                        </td>
                                        <td class="product-cart-img">
                                            <a href="{{ route('frontend.product.show', $item->options->slug) }}"><img
                                                    src="{{ $item->options->image }}" style="width: 150px;" alt></a>
                                        </td>
                                        <td class="product-name">
                                            <a href="{{ route('frontend.product.show', $item->options->slug) }}">{{ $item->name }}</a>
                                        </td>
                                        <td class="product-quantity">
                                            <i class="fas fa-plus butt" onclick="increment('{{ $item->rowId }}')"></i>
                                            <span style="margin: 0 10px;">{{ $item->qty }}</span>
                                            <i class="fas fa-minus butt" onclick="decrement('{{ $item->rowId }}')"></i>
                                        </td>
                                        <td class="product-price">
                                            <span><ins>{{ number_format($item->price, 0, '.', '.') }} ₫</ins></span>
                                        </td>
                                        <td class="product-total-price">
                                            <span>{{ number_format($item->qty * $item->price, 0, '.', '.') }} ₫</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    @if(\Gloudemans\Shoppingcart\Facades\Cart::count() > 0)
                        <form action="{{ route('frontend.cart.destroy') }}" method="GET" id="deleteAll">
                            <a class="checkout-button delete-confirm" href="#">Xóa toàn bộ</a>
                        </form>
                    @endif
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="shopping-cart-total">
                        <h2>Hóa đơn</h2>
                        <div class="shop-table table-responsive">
                            <table>
                                <tbody>
                                <tr class="order-total">
                                    <td data-title="Tổng tiền"><span><strong>{{ number_format(\Gloudemans\Shoppingcart\Facades\Cart::total(), 0, '.', '.') }} ₫</strong></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="proceed-to-checkout" id="checkd">
                            @if(\Illuminate\Support\Facades\Auth::check() && \Gloudemans\Shoppingcart\Facades\Cart::count() > 0)
                                <a href="{{ route('frontend.checkout') }}" class="checkout-button">Tiếp tục</a>
                            @elseif(\Illuminate\Support\Facades\Auth::check())
                                <p class="text-danger">Chưa có sản phẩm</p>
                            @else
                                <a href="{{ route('login.form') }}" class="checkout-button">Đăng nhập</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .butt:hover{
            cursor: pointer;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
        function increment(rowId){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ route('frontend.cart.increment') }}',
                method: 'POST',
                dataType: 'JSON',
                data: {rowId: rowId, _token: _token},
                success: function (data) {
                    location.reload();
                },
                error: function (){
                    swal("Thêm không thành công", "Không đủ sản phẩm", "error");
                }
            });
        }

        function decrement(rowId){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ route('frontend.cart.decrement') }}',
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
