@extends('backend.layouts.master')

@section('title')
    Chi tiết người dùng
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
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $user->name }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-envelope"></i> Email</strong>

                        <p class="text-muted">
                            {{ $user->email }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-mobile-alt"></i> Số điện thoại</strong>

                        <p class="text-muted">
                            {{ $user->phone }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Địa chỉ</strong>

                        <p class="text-muted">
                            {{ $user->address }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-user-tag"></i> Quyền hạn</strong>

                        <p class="text-muted">
                            {{ $user->role_text }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-clock"></i> Thời gian tạo</strong>

                        <p class="text-muted">
                            {{ date('d-m-Y', strtotime($user->created_at)) }}
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
                            @if($user->role == 0 || $user->role == 1)
                            <li class="nav-item"><a class="nav-link {{ ($user->role !== 2) ? 'active' : '' }}" href="#product"
                                                    data-toggle="tab">Sản phẩm đã tạo</a></li>
                            <li class="nav-item"><a class="nav-link" href="#category" data-toggle="tab">Danh mục đã
                                    tạo</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#trademark" data-toggle="tab">Thương hiệu đã
                                    tạo</a>
                            </li>
                            @endif
                            <li class="nav-item"><a class="nav-link {{ ($user->role == 2) ? 'active' : '' }}" href="#order" data-toggle="tab">Đơn hàng</a></li>
                            @if($user->id == \Illuminate\Support\Facades\Auth::user()->id)
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Thay đổi thông
                                    tin</a>
                            </li>
                            @endif
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane {{ ($user->role !== 2) ? 'active' : '' }}" id="product">
                                @if(count($products)>0)
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr class="bg-primary">
                                                <th>STT</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Thương hiệu</th>
                                                <th>Danh mục</th>
                                                <th>Thời gian tạo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <style>
                                                td {
                                                    vertical-align: middle !important;
                                                }

                                                .widspan {
                                                    width: 90px;
                                                    font-size: 14px;
                                                    font-weight: normal;
                                                    color: white !important;
                                                }
                                            </style>
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach($products as $product)
                                                @php
                                                    $i++;
                                                @endphp
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    @if($product->trademark == null)
                                                        <td>Không có</td>
                                                    @else
                                                        <td>{{ $product->trademark->name }}</td>
                                                    @endif
                                                    @if($product->category == null)
                                                        <td>Không có</td>
                                                    @else
                                                        <td>{{ $product->category->name }}</td>
                                                    @endif
                                                    <td>{{ date('d-m-Y', strtotime($product->created_at)) }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <br>
                                    <div
                                        class="d-flex justify-content-center">{!! $products->links() !!}</div>
                                @endif
                            </div>

                            <div class="tab-pane" id="category">
                                @if(count($categories)>0)
                                    <div class="card-body table-responsive p-0" style="max-height: 70vh; overflow: auto;">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr class="bg-primary">
                                                <th>STT</th>
                                                <th>Tên danh mục</th>
                                                <th>Danh mục cha</th>
                                                <th>Thương hiệu liên quan</th>
                                                <th>Thời gian tạo</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <style>
                                                .widspan {
                                                    padding: .25em 0;
                                                    width: 110px;
                                                    font-size: 14px;
                                                }
                                            </style>
                                            <tbody>
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach($categories as $category)
                                                @php
                                                    $i++;
                                                @endphp
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $category->name }}</td>
                                                    @if($category->parent_id == 0)
                                                        <td><span
                                                                class="badge badge-pill bg-success widspan font-weight-normal">Danh mục cha</span>
                                                        </td>
                                                    @else
                                                        @foreach($parents as $parent)
                                                            @if($category->parent_id == $parent->id)
                                                                <td><span
                                                                        class="badge badge-pill bg-warning widspan font-weight-normal">{{ $parent->name }}</span>
                                                                </td>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    <td>
                                                        <div class="btn-group" role="group"
                                                             aria-label="Button group with nested dropdown">
                                                            <div class="btn-group" role="group">
                                                                <button id="btnGroupDrop1" type="button"
                                                                        class="btn btn-info btn-sm dropdown-toggle"
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                    Danh sách
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="btnGroupDrop1">
                                                                    @foreach($category->trademarks as $trademark)
                                                                        <li><span class="dropdown-item"
                                                                                  href="#">{{ $trademark->name }}</span>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ date('d-m-Y', strtotime($category->created_at)) }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            <div class="tab-pane" id="trademark">
                                @if(count($trademarks)>0)
                                    <div class="card-body table-responsive p-0" style="max-height: 70vh; overflow: auto;">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr class="bg-primary">
                                                <th>STT</th>
                                                <th>Tên thương hiệu</th>
                                                <th>Thời gian tạo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach($trademarks as $trademark)
                                                @php
                                                    $i++;
                                                @endphp
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $trademark->name}}</td>
                                                    <td>{{ date('d-m-Y', strtotime($trademark->created_at)) }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            <div class="tab-pane {{ ($user->role == 2) ? 'active' : '' }}" id="order">
                                @if(count($orders)>0)
                                    <div class="card-body table-responsive p-0" style="max-height: 70vh; overflow: auto;">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr class="bg-primary">
                                                <th>Mã đơn hàng</th>
                                                <th>Tên người nhận</th>
                                                <th>Tổng tiền</th>
                                                <th>Chi tiết</th>
                                                <th>Tình trạng</th>
                                            </tr>
                                            </thead>
                                            <style>
                                                .widspan {
                                                    padding: .25em 0;
                                                    width: 110px;
                                                    font-size: 14px;
                                                }
                                            </style>
                                            <tbody>
                                            @foreach($orders as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ number_format($item->total_price, 0, '.', '.') }} ₫</td>
                                                    <td>
                                                        <a href="#" id="details"
                                                           data-toggle="modal"
                                                           data-target="#exampleModal"
                                                           data-id="{{ $item->id }}">
                                                            Chi tiết
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <p class="textt">{{ $item->status_text }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            <div class="tab-pane" id="settings">
                                <form class="form-horizontal" action="{{ route('backend.user.update', $user->id) }}"
                                      method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Tên</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="name"
                                                   value="{{ $user->name }}">

                                            @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="email"
                                                   value="{{ $user->email }}">

                                            @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName2" class="col-sm-2 col-form-label">Số điện thoại</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="phone"
                                                   value="{{ $user->phone }}">

                                            @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName2" class="col-sm-2 col-form-label">Địa chỉ</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="address"
                                                   value="{{ $user->address }}">

                                            @error('address')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputSkills" class="col-sm-2 col-form-label">Mật khẩu</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" name="password"
                                                   placeholder="Mật khẩu">

                                            @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @can('view', $user)
                                        @if($user->role !== \App\Models\User::ROLE_MANAGE)
                                            <div class="form-group row">
                                                <label for="inputSkills" class="col-sm-2 col-form-label">Quyền
                                                    hạn</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control select2" name="role"
                                                            style="width: 100%;">
                                                        @foreach(\App\Models\User::$role_text as $key => $value)
                                                            <option value="{{ $key }}"
                                                                    @if($user->role == $key)
                                                                    selected
                                                                @endif
                                                            >{{ $value }}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                    @endcan
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary">Thay đổi</button>
                                        </div>
                                    </div>
                                </form>
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

    <div class="modal fade" id="exampleModal" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chi tiết đơn hàng</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Đơn giá</th>
                            <th scope="col">Thành tiền</th>
                        </tr>
                        </thead>
                        <tbody id="tests">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                            data-dismiss="modal">Đồng ý
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if(Session::has('success'))
        <script>
            toastr.success("{!! Session::get('success') !!}");
        </script>
    @elseif(Session::has('error'))
        <script>
            toastr.error("{!! Session::get('error') !!}");
        </script>
    @endif

    <script>
        $(document).ready(function () {
            const formatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
                minimumFractionDigits: 0
            })

            $(document).on("click", "#details", function () {
                var id = $(this).data('id');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ route('frontend.order.detail') }}',
                    method: 'POST',
                    dataType: 'JSON',
                    data: {id: id, _token: _token},
                    success: function (data) {
                        $('#tests').empty();
                        var i = 0;
                        $.each(data, function (key, value) {
                            var total = value["quantity"] * value["price"];
                            i++;
                            $('#tests').append(
                                '<tr><th scope="row">' + i + '</th><td>' + value["name"] + '</td><td>' + value["quantity"] + '</td><td>' + formatter.format(value["price"]) + '</td><td>' + formatter.format(total) + '</td></tr>'
                            );
                        });
                    }
                });
            });
        });
    </script>
@endsection
