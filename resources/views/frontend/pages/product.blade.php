@extends('frontend.layouts.master')

@section('title')
    Sản phẩm
@endsection

@section('content')
    <section class="single-product-area mt-20">
        <div class="container">
            <!--Single Product Info Start-->
            <div class="row single-product-info mb-50">
                <!--Single Product Image Start-->
                <div class="col-lg-6 col-md-6">
                    <!--Product Tab Content Start-->
                    <div class="single-product-tab-content tab-content">
                        <div id="w1" class="tab-pane fade in active">
                            <div class="">
                                <img src="{{ $product->images[0]->image_url }}" alt>
                            </div>
                        </div>
                        @if(count($product->images) > 0)
                            @for($i = 2; $i <= count($product->images); $i++)
                                <div id="{{'w'.$i}}" class="tab-pane fade">
                                    <div class="">
                                        <img src="{{ $product->images[$i-1]->image_url }}" alt>
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                    <!--Product Tab Content End-->
                    <!--Single Product Tab Menu Start-->
                    <div class="single-product-tab">
                        <div class="nav single-product-tab-menu owl-carousel">
                            @if(count($product->images))
                                @php
                                    $i = 0;
                                @endphp
                                @foreach($product->images as $image)
                                    @php
                                        $i++;
                                    @endphp
                                    <a data-toggle="tab" href="{{'#w'.$i}}"><img src="{{ $image->image_url }}" alt></a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <!--Single Product Tab Menu Start-->
                </div>
                <!--Single Product Image End-->
                <!--Single Product Content Start-->
                <div class="col-lg-6 col-md-6">
                    <div class="single-product-content">
                        <h1 class="product-title">{{ $product->name }}</h1>
                        <!--Product Rating End-->
                        <!--Product Price Start-->
                        <div class="single-product-price">
                            <span class="new-price">Giá: {{ number_format($product->sale_price, 0, '.', '.') }} ₫</span>
                        </div>
                        <!--Product Price End-->
                        <!--Product Description Start-->
                        <div class="product-description">

                        </div>
                        <!--Product Description End-->
                        <!--Product Quantity Start-->
                        <button class="quantity-button" type="button" id="addToCart">Thêm vào giỏ hàng</button>

                        <!--Wislist Compare Button End-->
                        <!--Product Meta Start-->

                        <!--Product Sharing End-->
                    </div>
                </div>
                <!--Single Product Content End-->
            </div>
            <!--Single Product Info End-->
            <!--Discription Tab Start-->
            <div class="row">
                <div class="discription-tab">
                    <div class="col-lg-12">
                        <div class="discription-review-contnet mb-40">
                            <!--Discription Tab Menu Start-->
                            <div class="discription-tab-menu">
                                <ul class="nav">
                                    <li><a class="active" data-toggle="tab" href="#description">Mô tả sản phẩm</a></li>
                                    <li><a data-toggle="tab" href="#specifications">Thông số kỹ thuật</a></li>
                                </ul>
                            </div>
                            <!--Discription Tab Menu End-->
                            <!--Discription Tab Content Start-->
                            <div class="discription-tab-content tab-content">
                                <div id="description" class="tab-pane fade show active">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="description-content position-relative">
                                                @if(empty($product->content))
                                                    <style>
                                                        .description-content {
                                                            display: none;
                                                        }

                                                        #show_description {
                                                            display: none;
                                                        }
                                                    </style>
                                                @else
                                                    {!! $product->content !!}
                                                @endif
                                                <div class="bg-article"></div>
                                            </div>
                                        </div>
                                        <p id="show_description" class="text-center text-danger hoshow">Xem thêm</p>
                                    </div>
                                </div>

                                <div id="specifications" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="specifications-content position-relative">
                                                @if(!empty($product->content_more_json))
                                                    <table class="table">
                                                        <tbody>
                                                        @foreach($product->content_more_json as $key => $val)
                                                            <tr>
                                                                <td style="width: 30%;">{{ $key }}</td>
                                                                <th>{{ $val }}</th>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <style>
                                                        .specifications-content {
                                                            display: none;
                                                        }

                                                        #show_specifications {
                                                            display: none;
                                                        }
                                                    </style>
                                                @endif
                                                <div class="bg-article"></div>
                                            </div>
                                        </div>
                                        <p id="show_specifications" class="text-center text-danger hoshow">Xem thêm</p>
                                    </div>
                                </div>

                                <div id="specifications" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="review-page-comment">
                                                @if(!empty($product->content_more_json))
                                                    <table class="table">
                                                        <tbody>
                                                        @foreach($product->content_more_json as $key => $val)
                                                            <tr>
                                                                <td style="width: 30%;">{{ $key }}</td>
                                                                <th>{{ $val }}</th>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Discription Tab Content End-->
                        </div>
                    </div>
                </div>
            </div>
            <!--Discription Tab End-->
        </div>
    </section>
    <!--Single Product Area End-->
    <!--Related Products Area Start-->
    <section class="related-products-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!--Section Title1 Start-->
                    <div class="section-title1-border">
                        <div class="section-title1">
                            <h3>Sản phẩm liên quan</h3>
                        </div>
                    </div>
                    <!--Section Title1 End-->
                </div>
            </div>
            <div class="row">
                <div class="related-products owl-carousel">
                    @foreach($products as $pro)
                        <div class="col-lg-12">
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="{{ route('frontend.product.show', $pro->slug) }}">
                                        <img class="first-img" src="{{ $pro->images[0]->image_url }}" alt>
                                    </a>
                                </div>
                                <div class="product-content">
                                    <h2><a href="{{ route('frontend.product.show', $pro->slug) }}">{{ $pro->name }}</a>
                                    </h2>
                                    <div class="product-price">
                                        <span class="new-price">{{ number_format($pro->sale_price, 0, '.', '.') }} ₫</span>
                                        <a class="button add-btn"
                                           href="{{ route('frontend.product.show', $pro->slug) }}">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#show_description').click(function () {
                $('.description-content').css({
                    'height': '100%'
                }, $('#show').hide(), $('.bg-article').hide(), $('#show_description').hide())
            })
            $('#show_specifications').click(function () {
                $('.specifications-content').css({
                    'height': '100%'
                }, $('#show').hide(), $('.bg-article').hide(), $('#show_specifications').hide())
            })

            $('#addToCart').click(function () {
                var id = {{ $product->id }};
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ route('frontend.cart.add') }}',
                    method: 'POST',
                    dataType: 'JSON',
                    data: {id: id, _token: _token},
                    success: function (data) {
                        swal("Thêm thành công", "Xem chi tiết trong giỏ hàng", "success");
                        console.log(data);
                    },
                    error: function () {
                        swal("Thêm không thành công", "Không đủ sản phẩm", "error");
                    }
                });
            });
        });
    </script>

    <style>
        .description-content {
            height: 500px;
            overflow: hidden;
        }

        .specifications-content {
            height: 500px;
            overflow: hidden;
        }

        #show_description, #show_specifications {
            margin-top: 15px;
            z-index: 2;
            margin: 0 auto;
        }

        .hoshow:hover {
            cursor: pointer;
            text-decoration: underline;
        }

        .bg-article {
            background: linear-gradient(to bottom, rgba(255 255 255/0), rgba(255 255 255/62.5), rgba(255 255 255/1));
            bottom: 0;
            height: 105px;
            left: 0;
            position: absolute;
            width: 100%;
        }
    </style>
@endsection
