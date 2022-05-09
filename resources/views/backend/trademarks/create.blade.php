@extends('backend.layouts.master')

@section('title')
    Tạo mới thương hiệu
@endsection

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
        </div>
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
                        <h3 class="card-title">Tạo mới danh mục</h3>
                    </div>
                    <form role="form" action="{{ route('backend.trademark.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên thương hiệu</label>
                                <input type="text" class="form-control" id="" name="name" placeholder="Nhập tên thương hiệu" value="{{ old('name') }}">


                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('backend.trademark.index') }}" class="btn btn-danger">Huỷ bỏ</a>
                            <button type="submit" class="btn btn-success">Tạo mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
    </div>
@endsection
