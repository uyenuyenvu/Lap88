@extends('backend.layouts.master')

@section('title')
    Tạo mới danh mục
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
                        <h3 class="card-title">Tạo mới danh mục</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('backend.category.store') }}" method="POST"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên danh mục</label>
                                <input type="text" class="form-control" id="" name="name"
                                       placeholder="Điền tên danh mục" value="{{ old('name') }}">

                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Danh mục cha</label>
                                <select class="form-control select2" name="parent_id" style="width: 100%;">
                                    <option value="0">--Chọn danh mục---</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Thương hiệu liên quan</label>
                                <div class="row">
                                    @for($i = 0; $i < count($trademarks); $i++)
                                        <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="trademark_id[]"
                                                       value="{{ $trademarks[$i]->id }}" id="flexSwitchCheckChecked"
                                                       style="margin-left: -1.25rem;">
                                                <label class="form-check-label" for="flexSwitchCheckChecked"
                                                       style="margin-left: 1.25rem;">{{ $trademarks[$i]->name }}</label>
                                            </div>
                                        </div>
                                    @if($i == count($trademarks) - 1)
                                        @break
                                    @endif
                                    @php
                                        $i++;
                                    @endphp
                                        <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="trademark_id[]"
                                                       value="{{ $trademarks[$i]->id }}" id="flexSwitchCheckChecked"
                                                       style="margin-left: -1.25rem;">
                                                <label class="form-check-label" for="flexSwitchCheckChecked"
                                                       style="margin-left: 1.25rem;">{{ $trademarks[$i]->name }}</label>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('backend.category.index') }}" class="btn btn-danger">Huỷ bỏ</a>
                            <button type="submit" class="btn btn-success">Tạo mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
    </div>
@endsection
