@extends('frontend.layouts.master')

@section('title')
    Tài khoản
@endsection

@section('content')
    <div class="account">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-md-4 col-12 account_left">
                    <div class="text_left">
                        <img style="width: 35px" src="images/user.png" alt="">&ensp;
                        <span>Tài khoản của</span>
                        <div>
                            <div style="padding: 15px 0;">
                                <i class="fas fa-user"></i>
                                <span><a href="{{ route('frontend.account') }}">Thông tin tài khoản</a></span>
                            </div>
                            <div>
                                <form action="{{ route('frontend.order') }}" method="POST" id="form_order">
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
                    <div class="account_info" style="margin-bottom: 30px;">
                        <form action="{{ route('frontend.account.update', \Illuminate\Support\Facades\Auth::user()->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <h2>Thông tin cá nhân</h2>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Họ tên</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" value="{{ \Illuminate\Support\Facades\Auth::user()->name }}" name="name">

                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ \Illuminate\Support\Facades\Auth::user()->email }}" name="email">

                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" name="password">

                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" value="{{ \Illuminate\Support\Facades\Auth::user()->phone }}" name="phone">

                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" value="{{ \Illuminate\Support\Facades\Auth::user()->address }}" name="address">

                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-danger" style="border-radius: 5px">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function (){
            $('#orderss').click(function (){
                $('#orderss').parent().parent().submit();
            });
        });
    </script>
@endsection
