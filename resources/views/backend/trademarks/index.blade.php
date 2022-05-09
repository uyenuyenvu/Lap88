@extends('backend.layouts.master')

@section('title')
    Danh sách thương hiệu
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
                        <h3 class="card-title">Thương hiệu</h3>

                        {{--                        <div class="card-tools">--}}
                        {{--                            <div class="input-group input-group-sm" style="width: 150px;">--}}
                        {{--                                <input type="text" name="table_search" class="form-control float-right"--}}
                        {{--                                       placeholder="Search">--}}

                        {{--                                <div class="input-group-append">--}}
                        {{--                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên thương hiệu</th>
                                <th>Người tạo</th>
                                <th>Thời gian tạo</th>
                                <th>Thời gian cập nhật</th>
                                <th></th>
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
                                    <td>{{ $trademark->user->name }}</td>
                                    <td>{{ date('d-m-Y', strtotime($trademark->created_at)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($trademark->updated_at)) }}</td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm juss {{ (\Illuminate\Support\Facades\Auth::user()->role == 0 || \Illuminate\Support\Facades\Auth::user()->id == $trademark->user_id) ? '' : 'disabled'}}"
                                           href="{{ route('backend.trademark.edit', $trademark->id) }}">
                                            <i class="fas fa-user-edit"></i> Sửa
                                        </a>
                                        <form action="{{ route('backend.trademark.destroy', $trademark->id) }}"
                                              method="POST" style="display: inline">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" class="btn btn-danger btn-sm delete-confirm juss"
                                                {{ (\Illuminate\Support\Facades\Auth::user()->role == 0 || \Illuminate\Support\Facades\Auth::user()->id == $trademark->user_id) ? '' : 'disabled'}}>
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
                        <div class="col-12 col-md-6">
                            <div class="d-flex ml-3 mb-3 pot">
                                <a href="{{ route('backend.trademark.export') }}" class="btn btn-sm btn-info d-inline-block"
                                   style="margin-right: 10px;">
                                    <i class="fas fa-file-export"></i> Export Excel
                                </a>
                                <form action="{{ route('backend.trademark.import') }}" method="POST" enctype="multipart/form-data" class="d-flex">
                                    @csrf
                                    <input class="form-control form-control-sm" id="formFileSm" type="file" name="file" accept=".xlsx" required>
                                    <button type="submit" class="btn btn-sm btn-info">Import</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="float-right mr-4">{!! $trademarks->links() !!}</div>
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
        $('.delete-confirm').click(function(event) {
            var form =  $(this).closest("form");
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
    </script>
@endsection
