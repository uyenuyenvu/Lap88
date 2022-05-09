@extends('backend.layouts.master')

@section('title')
    Chi tiết nhà cung cấp
@endsection

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
        </div><!-- /.row -->
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Chi tiết nhà cung cấp</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-house-user"></i> Tên nhà cung cấp</strong>

                        <p class="text-muted">
                            {{ $supplier->name }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-envelope"></i> Email</strong>

                        <p class="text-muted">
                            {{ $supplier->email }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-mobile-alt"></i> Số điện thoại</strong>

                        <p class="text-muted">
                            {{ $supplier->phone }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Địa chỉ</strong>

                        <p class="text-muted">
                            {{ $supplier->address }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-clock"></i> Thời gian tạo</strong>

                        <p class="text-muted">
                            {{ date('d-m-Y', strtotime($supplier->created_at)) }}
                        </p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#product"
                                                        data-toggle="tab">Sản phẩm cung cấp</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="product">
                                <div class="card-body table-responsive p-0" style="max-height: 65vh; overflow: auto;">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr class="bg-primary">
                                            <th>STT</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Thời gian tạo</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach($supplier->products as $product)
                                            @php
                                                $i++;
                                            @endphp
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ date('d-m-Y', strtotime($product->created_at)) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection
