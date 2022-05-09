@extends('frontend.layouts.master')

@section('title')
    Đăng nhập
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
                                <li>Đăng nhập</li>
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
                    <div class="customer-login-register">
                        <div class="login-form">
                            <form action="{{ route('login.store') }}" method="post">
                                @csrf
                                <div class="form-fild">
                                    <p><label>Email <span class="required">*</span></label></p>
                                    <input type="text" name="email" value>

                                    @error('email')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-fild">
                                    <p><label>Mật khẩu <span class="required">*</span></label></p>
                                    <input type="password" name="password" value>

                                    @error('password')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="login-submit">
                                    <button type="submit" class="form-button">Đăng nhập</button>
                                    @error('login')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="lost-password">
                                    <a href="#" data-toggle="modal" data-target="#exampleModal">Quên mật khẩu?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3"></div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Quên mật khẩu?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('reset.password.sendmail') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-fild">
                            <p><label>Nhập địa chỉ email <span class="required">*</span></label></p>
                            <input type="text" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </div>
                </form>
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
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
            integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
            integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF"
            crossorigin="anonymous"></script>
@endsection
