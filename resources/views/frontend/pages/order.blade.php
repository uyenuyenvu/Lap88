<?php
use App\Models\Order;

  ?>  

@extends('frontend.layouts.master')

@section('title')
    Đơn hàng
@endsection

@section('content')
    <div class="account">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-md-4 col-12 account_left">
                    <div class="text_left">
                        <div>
                            <div style="padding: 15px 0;">
                                <i class="fas fa-user"></i>
                                <span><a href="{{ route('frontend.account') }}">Thông tin tài khoản</a></span>
                            </div>
                            <div>
                                <form action="{{ route('frontend.order') }}" method="POST">
                                    @csrf
                                    <i class="fas fa-clipboard-list"></i>
                                    <span><a href="#" id="orderss">Quản lý đơn hàng</a></span>
                                    <input type="hidden" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}"
                                           name="user_id">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9 col-md-8 col-12 account_right">
                    <div class="account_listOrder" style="max-height: 70vh; overflow: auto;">
                        <h2>Đơn hàng của bạn</h2>
                        <div class="table-responsive-sm">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Mã ĐH</th>
                                    <th>Tên người nhận</th>
                                    <th style="vertical-align: top;">Tổng tiền</th>
                                    <th>Thông tin</th>
                                    <th>Thanh toán</th>
                                    <th>Tình trạng</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach($orders as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ number_format($item->total_price, 0, '.', '.') }} ₫</td>
                                        
                                         <td >
                                            
                                            <a href="#" id="details"
                                               data-toggle="modal"
                                               data-target="#exampleModal"
                                               data-id="{{ $item->id }}" class="btn btn-danger">
                                                Chi tiết
                                            </a>
                                               <!-- Trigger the modal with a button -->
                                               @if ($item->status == 0 && $item ->type ==1)
                                                   
                                               
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#huydon{{$item->id}}">Hủy đơn hàng</button>
                                        @endif
                                        <!-- Modal -->
                                        <div id="huydon{{$item->id}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Lý do</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p><textarea rows="5" id="lydohuydon{{$item->id}}" required placeholder="Lý do hủy đơn hàng"></textarea></p>
                                                </div>
                                                <div class="modal-footer">
                                                   
                                                   
                                                    <button type="button" id="{{$item->id}}" onclick="Huydonhang(this.id)" class="btn btn-success" >Gửi lý do hủy</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                    
                                                </div>
                                                </div>
                                            </div>
                                            </div>

                                         </td>
                                        </td>
                                        <td>
                                            @if($item -> type ==2)
                                            Ví VNPAY
                                        @else
                                        Ship Code    
                                        @endif
                                        </td>
                                        <td>
                                            <p class="textt">{{ $item->status_text }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function Huydonhang(id){
             var lydo = $('#lydohuydon' + id).val();
            
             var _token = $('input[name="_token"]').val();
            
            $.ajax({
                url: '{{ route('frontend.order.huy-don-hang') }}',
                method:"post",
                data:{id:id, lydo: lydo, _token:_token},
                dataType: 'JSON',
                success: function(){
                    alert('Hủy dơn hàng thành công');
                },
                error: function () {
                    alert("Hủy đơn hàng không thành công", "error");
                }
            });
        }
    </script>
    <div class="modal fade" id="exampleModal" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chi tiết đơn hàng</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Đơn giá</th>
                            <th scope="col">Thành tiền</th>
                        </tr>
                        </thead>
                        <tbody id="tests">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                            data-dismiss="modal">Đồng ý
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .modal-content {
            border-radius: .3rem;
            overflow: unset;
        }

        .modal-header {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            border-top-left-radius: .3rem;
            border-top-right-radius: .3rem;
        }

        .modal-header > h5 {
            font-size: 1.25rem;
            font-weight: 500;
        }

        .modal-header button.close {
            border: none;
        }

        .modal-body {
            padding: 1rem;
        }

        .btn {
            border-radius: .25rem;
        }

        @media (min-width: 992px) {
            .modal-lg, .modal-xl {
                max-width: 800px;
            }
        }

        @media (min-width: 1200px) {
            .modal-xl {
                max-width: 1140px;
            }
        }
    </style>
    <script>
        $(document).ready(function () {
            const formatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
                minimumFractionDigits: 0
            })

            $('#orderss').click(function (){
                $('#orderss').parent().parent().submit();
            });

            $(document).on("click", "#details", function () {
                var id = $(this).data('id');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ route('frontend.order.detail') }}',
                    method: 'POST',
                    dataType: 'JSON',
                    data: {id: id, _token: _token},
                    success: function (data) {
                        $('#tests').empty();
                        var i = 0;
                        $.each(data, function (key, value) {
                            var total = value["quantity"] * value["price"];
                            i++;
                            $('#tests').append(
                                '<tr><th scope="row">' + i + '</th><td>' + value["name"] + '</td><td>' + value["quantity"] + '</td><td>' + formatter.format(value["price"]) + '</td><td>' + formatter.format(total) + '</td></tr>'
                            );
                        });
                    }
                });
            });
        });
    </script>
@endsection
