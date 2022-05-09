@extends('backend.layouts.master')

@section('title')
    Tạo mới nhà cung cấp
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
                        <h3 class="card-title">Tạo mới nhà cung cấp</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('backend.supplier.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên nhà cung cấp</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Tên nhà cung cấp">

                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">

                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại">

                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ</label>
                                <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Địa chỉ">

                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sản phẩm cung cấp</label>
                                <div class="row" style="max-height: 100vh; overflow: auto;">
                                    @for($i = 0; $i < count($products); $i++)
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="product_id[]"
                                                       value="{{ $products[$i]->id }}" id="flexSwitchCheckChecked"
                                                       style="margin-left: -1.25rem;">
                                                <label class="form-check-label" for="flexSwitchCheckChecked"
                                                       style="margin-left: 1.25rem;">{{ $products[$i]->name }}</label>
                                            </div>
                                        </div>
                                        @if($i == count($products) - 1)
                                            @break
                                        @endif
                                        @php
                                            $i++;
                                        @endphp
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="product_id[]"
                                                       value="{{ $products[$i]->id }}" id="flexSwitchCheckChecked"
                                                       style="margin-left: -1.25rem;">
                                                <label class="form-check-label" for="flexSwitchCheckChecked"
                                                       style="margin-left: 1.25rem;">{{ $products[$i]->name }}</label>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <a href="{{ route('backend.supplier.index') }}" class="btn btn-danger">Huỷ bỏ</a>
                            <button type="submit" class="btn btn-success">Tạo mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
