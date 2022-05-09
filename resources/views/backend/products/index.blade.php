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
                        <h3 class="card-title mb-1">Sản phẩm mới</h3>

                        <div class="card-tools" style="display: flex">
                            <select class="form-select form-select-sm" aria-label="Default select example"
                                    name="trademark" style="margin-right: 10px;" onchange="location = this.value;">
                                <option selected value="">Chọn thương hiệu</option>
                                <option value="{{ request()->fullUrlWithQuery(['trademark' => 0]) }}">Không có thương
                                    hiệu
                                </option>
                                @foreach($trademarks as $trademark)
                                    <option
                                        value="{{ request()->fullUrlWithQuery(['trademark' => $trademark->id]) }}">{{ $trademark->name }}</option>
                                @endforeach
                            </select>
                            <select class="form-select form-select-sm" aria-label="Default select example"
                                    name="category" style="margin-right: 10px;" onchange="location = this.value;">
                                <option selected value="">Chọn danh mục</option>
                                <option value="{{ request()->fullUrlWithQuery(['category' => 0]) }}">Không có danh mục
                                </option>
                                @foreach($categories as $categorie)
                                    <option
                                        value="{{ request()->fullUrlWithQuery(['category' => $categorie->id]) }}">{{ $categorie->name }}</option>
                                @endforeach
                            </select>
                            <select class="form-select form-select-sm" aria-label="Default select example" name="status"
                                    style="margin-right: 10px;" onchange="location = this.value;">
                                <option selected value="">Chọn trạng thái</option>
                                @foreach(\App\Models\Product::$status_text as $key => $value)
                                    <option
                                        value="{{ request()->fullUrlWithQuery(['status' => $key]) }}">{{ $value }}</option>
                                @endforeach
                            </select>

                            <form action="{{ route('backend.product.index') }}" method="GET">
                                <div class="input-group input-group-sm winp" style="width: 150px; margin-top: 0;">
                                    <input type="text" name="q" class="form-control float-right"
                                           placeholder="Tìm kiếm" required value="{{ $keyW }}">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive-sm p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th id="namepro">Tên sản phẩm</th>
                                <th>Thương hiệu</th>
                                <th id="cate">Danh mục</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach($products as $product)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td><a href="{{ route('frontend.product.show', $product->slug) }}">{{ $product->name }}</a></td>
                                    @if($product->trademark !== null)
                                        <td>{{ $product->trademark->name }}</td>
                                    @else
                                        <td>Không có</td>
                                    @endif
                                    @if($product->category !== null)
                                        <td>{{ $product->category->name }}</td>
                                    @else
                                        <td>Không có</td>
                                    @endif
                                   
                                    <td>
                                        @if($product->status == 0)
                                            <span
                                                class="badge badge-pill bg-warning widspan">{{ $product->status_text }}</span>
                                        @elseif($product->status == 1)
                                            <span
                                                class="badge badge-pill bg-success widspan">{{ $product->status_text }}</span>
                                        @else
                                            <span
                                                class="badge badge-pill bg-danger widspan">{{ $product->status_text }}</span>
                                        @endif
                                    </td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-primary btn-sm juss"
                                           href="{{ route('frontend.product.show', $product->slug) }}">
                                            <i class="fas fa-street-view"></i> Xem
                                        </a>
                                        <a class="btn btn-info btn-sm juss {{ (\Illuminate\Support\Facades\Auth::user()->role == 0 || \Illuminate\Support\Facades\Auth::user()->id == $product->user_id) ? '' : 'disabled'}}"
                                           href="{{ route('backend.product.edit', $product->id) }}">
                                            <i class="fas fa-user-edit"></i> Sửa
                                        </a>
                                        <form action="{{ route('backend.product.destroy', $product->id) }}"
                                              method="POST" style="display: inline">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" class="btn btn-danger btn-sm delete-confirm juss"
                                                {{ (\Illuminate\Support\Facades\Auth::user()->role == 0 || \Illuminate\Support\Facades\Auth::user()->id == $product->user_id) ? '' : 'disabled'}}>
                                                <i class="fas fa-eraser"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <div class="d-flex ml-3 mb-3">
                                <a href="{{ route('backend.product.export') }}" class="btn btn-sm btn-info d-inline-block"
                                   style="margin-right: 10px;">
                                    <i class="fas fa-file-export"></i> Export Excel
                                </a>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="float-right mr-4">{!! $products->appends(request()->input())->links() !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
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
        $('.delete-confirm').click(function (event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: `Bạn có muốn xóa không?`,
                text: "Nếu bạn xóa nó, bạn sẽ không thể khôi phục lại được",
                icon: "warning",
                buttons: ["Không", "Xóa"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

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

        @media ( min-width: 521px ) and (max-width: 767px){
            #namepro{
                width: 20% !important;
            }
        }
        @media ( min-width: 768px ) and (max-width: 992px){
            #namepro{
                width: 19%;
            }
            #cate{
                width: 12%;
            }
        }
    </style>
@endsection
