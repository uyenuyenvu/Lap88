@extends('frontend.layouts.master')

@section('title')
    Thay đổi mật khẩu
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
                                <li>Thay đổi mật khẩu</li>
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
                            <form action="{{ route('reset.password') }}" method="POST">
                                @csrf
                                <div class="form-fild">
                                    <p><label>Mật khẩu mới <span class="required">*</span></label></p>
                                    <input type="password" name="password">
                                    <input type="hidden" value="{{ $token }}" name="token">

                                    @error('password')
                                    <p style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-fild">
                                    <p><label>Nhập lại mật khẩu <span class="required">*</span></label></p>
                                    <input type="password" name="password_confirmation">
                                </div>
                                <div class="register-submit">
                                    <button type="submit" class="form-button">Thay đổi</button>
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
