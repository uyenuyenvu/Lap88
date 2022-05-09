@extends('frontend.layouts.master')

@section('title')
    Tìm kiếm
@endsection

@section('content')
    <div class="heading-banner-area pt-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-banner">
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="index.html">Trang chủ</a><span class="breadcome-separator">&gt;</span></li>
                                <li>Tìm kiếm</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product-list-grid-view-area mt-20">
        <div class="container">
            <div class="row">
                <!--Shop Product Area Start-->
                <div class="col-lg-12">
                    <div class="shop-tab-menu">
                        <div class="row">
                            <!--List & Grid View Menu Start-->
                            <div class="col-lg-5 col-md-5 col-xl-6 col-12">
                                <div class="shop-tab">
                                    <ul class="nav">
                                        <li><a class="active" data-toggle="tab" href="#grid-view"><i
                                                    class="ion-android-apps"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <!--List & Grid View Menu End-->
                            <!-- View Mode Start-->
                            <div class="col-lg-7 col-md-7 col-xl-6 col-12">
                                <div class="show-result">
                                    <p>Kết quả tìm kiếm</p>
                                </div>
                            </div>
                            <!-- View Mode End-->
                        </div>
                    </div>
                    <!--Shop Tab Menu End-->
                    <!--Shop Product Area Start-->
                    <div class="shop-product-area">
                        <div class="tab-content">
                            <!--Grid View Start-->
                            <div id="grid-view" class="tab-pane fade show active">
                                <div class="row product-container">
                                    <!--Single Product Start-->
                                    @foreach($products as $product)
                                        <div class="col-lg-3 col-md-3 item-col2">
                                            <div class="single-product" style="height: 100%;">
                                                <div class="product-img" style="height: 65%;">
                                                    <a href="{{ route('frontend.product.show', $product->slug) }}"
                                                       style="height: 100%;">
                                                        @if(count($product->images))
                                                            <img class="first-img"
                                                                 src="{{ $product->images[0]->image_url }}" alt="anh"
                                                                 style="height: 100%; width: 80%; margin-left: 10%;">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="product-content" style="height: 35%;">
                                                    <h2 style="height: 65%; width: 90%; margin: 0 auto;">
                                                        <a href="{{ route('frontend.product.show', $product->slug) }}">{{ $product->name }}</a>
                                                    </h2>

                                                    <style>
                                                        a.button.add-btn, a.button.add-btn.big {
                                                            top: auto;
                                                            bottom: 0;
                                                        }
                                                    </style>
                                                    <div class="product-price" style="height: 35%;">
                                                        <span class="new-price">{{ number_format($product->sale_price) }} <b>₫</b></span>
                                                        <a class="button add-btn"
                                                           href="{{ route('frontend.product.show', $product->slug) }}"
                                                           data-toggle="tooltip">Xem chi tiết</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! $products->appends(request()->input())->links() !!}
                </div>
                <!--Shop Product Area End-->
            </div>
        </div>
    </div>

    <style>
        .priceui > i {
            font-size: 14px;
            color: #eb3e32;
        }

        .priceui > a {
            font-size: 14px;
        }

        .priceui > a:hover {
            text-decoration: underline;
        }
    </style>
@endsection
