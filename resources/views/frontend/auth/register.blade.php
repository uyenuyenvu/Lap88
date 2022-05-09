@extends('frontend.layouts.master')

@section('title')
    Đăng ký
@endsection

@section('content')
    <section class="heading-banner-area pt-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-banner">
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="{{ route('frontend.index') }}">Trang chủ</a><span class="breadcome-separator">></span></li>
                                <li>Đăng ký</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="my-account-area mt-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3"></div>
                <div class="col-lg-6 col-md-6">
                    <div class="customer-login-register register-pt-0">
                        <div class="register-form">
                            <form action="{{ route('register.store') }}" method="POST">
                                @csrf
                                <div class="form-fild">
                                    <p><label>Họ tên<span class="required">*</span></label></p>
                                    <input type="text" name="name" value="{{ old('name') }}">

                                    @error('name')
                                    <p style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-fild">
                                    <p><label>Email <span class="required">*</span></label></p>
                                    <input type="text" name="email" value="{{ old('email') }}">

                                    @error('email')
                                    <p style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-fild">
                                    <p><label>Số điện thoại <span class="required">*</span></label></p>
                                    <input type="text" name="phone" value="{{ old('phone') }}">

                                    @error('phone')
                                    <p style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-fild">
                                    <p><label>Địa chỉ <span class="required">*</span></label></p>
                                    <input type="text" name="address" value="{{ old('address') }}">

                                    @error('address')
                                    <p style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-fild">
                                    <p><label>Mật khẩu <span class="required">*</span></label></p>
                                    <input type="password" name="password">

                                    @error('password')
                                    <p style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-fild">
                                    <p><label>Nhập lại mật khẩu <span class="required">*</span></label></p>
                                    <input type="password" name="password_confirmation">
                                </div>
                                <div class="register-submit">
                                    <button type="submit" class="form-button">Đăng ký</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3"></div>
            </div>
        </div>
    </section>
@endsection
