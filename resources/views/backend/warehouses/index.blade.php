@extends('backend.layouts.master')

@section('title')
    Danh sách sản phẩm
@endsection

@section('script_top')
    <link rel="stylesheet" href="/backend/dist/css/respon.css">
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title mb-1">Quản lý kho hàng</h3>
                        
                        <div class="card-tools" style="display: flex">
                            <select class="form-select form-select-sm" aria-label="Default select example" name="status"
                        style="margin-right: 10px;" onchange="location = this.value;">
                    <option selected value="">Chọn trạng thái</option>
                    @foreach(\App\Models\Product::$status_text as $key => $value)
                        <option
                            value="{{ request()->fullUrlWithQuery(['status' => $key]) }}">{{ $value }}</option>
                    @endforeach
                </select>

                            <form action="{{ route('backend.warehouse.index') }}" method="GET">
                                <div class="input-group input-group-sm" style="width: 150px; margin-top: 0;">
                                    <input type="text" name="q" class="form-control float-right"
                                           placeholder="Tìm kiếm" value="{{ $keyW }}">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    
                                </div>
                            </form>
                           

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Nhập kho</th>
                                <th>Xuất kho</th>
                                <th>Tồn kho</th>
                                
                                <th colspan="2" class="text-center">Trạng thái</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach($warehouses as $warehouse)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $warehouse->product->name }}</td>
                                    <td>{{ $warehouse->entered }}</td>
                                    <td>{{ $warehouse->sold }}</td>
                                    <td>{{ $warehouse->product->quantity }}</td>
                                    {{-- <td>{{ $warehouse->purchase->name }}</td> --}}
                                    <td class="text-center">
                                        @if($warehouse->product->status == 0)
                                            <span class="badge badge-pill bg-warning widspan">{{ $warehouse->product->status_text }}</span>
                                        @elseif($warehouse->product->status == 1)
                                            <span class="badge badge-pill bg-success widspan">{{ $warehouse->product->status_text }}</span>
                                        @else
                                            <span class="badge badge-pill bg-danger widspan">{{ $warehouse->product->status_text }}</span>
                                        @endif
                                    </td>
                                    @if($warehouse->product->quantity == 0)
                                        <td class="text-center"><span class="badge badge-pill bg-secondary widspan">{{ \App\Models\Warehouse::END }}</span></td>
                                    @elseif($warehouse->product->quantity < 20)
                                        <td class="text-center"><span class="badge badge-pill bg-warning widspan">{{ \App\Models\Warehouse::ALMOST_OVER }}</span></td>
                                    @else
                                        <td class="text-center"><span class="badge badge-pill bg-info widspan">{{ \App\Models\Warehouse::NORMAL }}</span></td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            {{--                            <div class="d-flex ml-3 mb-3">--}}
                            {{--                                <a href="{{ route('backend.warehouse.export') }}" class="btn btn-sm btn-info d-inline-block"--}}
                            {{--                                   style="margin-right: 10px;">--}}
                            {{--                                    <i class="fas fa-file-export"></i> Export Excel--}}
                            {{--                                </a>--}}
                            {{--                                <form action="{{ route('backend.warehouse.import') }}" method="POST" enctype="multipart/form-data" class="d-flex">--}}
                            {{--                                    @csrf--}}
                            {{--                                    <input class="form-control form-control-sm" id="formFileSm" type="file" name="file" accept=".xlsx" required>--}}
                            {{--                                    <button type="submit" class="btn btn-sm btn-info">Import</button>--}}
                            {{--                                </form>--}}
                            {{--                            </div>--}}
                        </div>
                        <div class="col-6">
                            <div
                                class="float-right mr-4">{!! $warehouses->appends(request()->input())->links() !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->

    <style>
        td {
            vertical-align: middle !important;
        }

        .widspan {
            width: 90px;
            font-size: 14px;
            font-weight: normal;
        }

        .table > :not(:last-child) > :last-child > * {
            border-bottom-color: #dee2e6;
        }
    </style>
@endsection
