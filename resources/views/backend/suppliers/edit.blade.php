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
                    <form role="form" action="{{ route('backend.supplier.update', $supplier->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên</label>
                                <input type="text" class="form-control" name="name" value="{{ $supplier->name }}">

                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $supplier->email }}">

                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại</label>
                                <input type="text" class="form-control" name="phone" value="{{ $supplier->phone }}">

                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ</label>
                                <input type="text" class="form-control" name="address" value="{{ $supplier->address }}">

                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Thương hiệu liên quan</label>
                                <div class="row">
                                    @for ($j = 0; $j < count($products); $j++)
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="product_id[]"
                                                       value="{{ $products[$j]->id }}" id="flexSwitchCheckChecked"
                                                       style="margin-left: -1.25rem;"

                                                @for ($i = 0; $i < count($supplier->products); $i++)
                                                    @if ($supplier->products[$i]->id == $products[$j]->id)
                                                        {{ 'checked' }}
                                                        @endif
                                                    @endfor

                                                >
                                                <label class="form-check-label" for="flexSwitchCheckChecked"
                                                       style="margin-left: 1.25rem;">{{ $products[$j]->name }}</label>
                                            </div>
                                        </div>
                                        @if($j == count($products) - 1)
                                            @break
                                        @endif
                                        @php
                                            $j++;
                                        @endphp
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="product_id[]"
                                                       value="{{ $products[$j]->id }}" id="flexSwitchCheckChecked"
                                                       style="margin-left: -1.25rem;"

                                                @for ($i = 0; $i < count($supplier->products); $i++)
                                                    @if ($supplier->products[$i]->id == $products[$j]->id)
                                                        {{ 'checked' }}
                                                        @endif
                                                    @endfor

                                                >
                                                <label class="form-check-label" for="flexSwitchCheckChecked"
                                                       style="margin-left: 1.25rem;">{{ $products[$j]->name }}</label>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <a href="{{ route('backend.supplier.index') }}" class="btn btn-danger">Huỷ bỏ</a>
                            <button type="submit" class="btn btn-success">Thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
    </div>
@endsection
