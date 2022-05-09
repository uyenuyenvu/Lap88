@extends('backend.layouts.master')

@section('title')
    Thay đổi thông tin người dùng
@endsection

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
        </div><!-- /.row -->
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Thay đổi thông tin người dùng</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('backend.user.update', $user->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Họ tên</label>
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}">

                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="text" class="form-control" name="email" value="{{ $user->email }}">

                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại</label>
                                <input type="number" class="form-control" name="phone" value="{{ $user->phone }}">

                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ</label>
                                <input type="text" class="form-control" name="address" value="{{ $user->address }}">

                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mật khẩu</label>
                                <input type="password" class="form-control" name="password" placeholder="Mật khẩu">

                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            @can('view', $user)
                                @if($user->role !== \App\Models\User::ROLE_MANAGE)
                                    <div class="form-group">
                                        <label>Quyền</label>
                                        <select class="form-control select2" name="role" style="width: 100%;">
                                            @foreach(\App\Models\User::$role_text as $key => $value)
                                                <option value="{{ $key }}"
                                                        @if($user->role == $key)
                                                        selected
                                                    @endif
                                                >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endcan
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <a href="{{ route('backend.user.index') }}" class="btn btn-danger">Huỷ bỏ</a>
                            <button type="submit" class="btn btn-success">Thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
    </div>
@endsection
