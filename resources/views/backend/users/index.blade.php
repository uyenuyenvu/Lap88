@extends('backend.layouts.master')

@section('title')
    Danh sách người dùng
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
                        <h3 class="card-title mb-1">Danh sách người dùng</h3>
                        <div class="card-tools d-flex">
                            <select class="form-select form-select-sm" aria-label="Default select example"
                                    name="status" style="margin-right: 10px;" onchange="location = this.value;">
                                <option>Quyền hạn</option>
                                @foreach(\App\Models\User::$role_text as $key => $value)
                                    <option
                                        value="{{ request()->fullUrlWithQuery(['role' => $key]) }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <form action="{{ route('backend.user.index') }}" method="GET">
                                <div class="input-group input-group-sm" style="width: 150px; margin-top: 0;">
                                    <input type="text" name="q" class="form-control float-right"
                                           placeholder="Tìm kiếm" value="{{ $keyU }}">

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
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Quyền hạn</th>
                                <th></th>
                            </tr>
                            </thead>
                            @php
                                $i = 0;
                            @endphp
                            <tbody>
                            @foreach($users as $user)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->role_text }}</td>
                                    <td class="project-actions text-right">
                                        @can('view', $user)
                                            <a class="btn btn-primary btn-sm juss"
                                               href="{{ route('backend.user.show', $user->id) }}">
                                                <i class="fas fa-street-view"></i> Xem
                                            </a>
                                        @endcan
                                        @can('update', $user)
                                            <a class="btn btn-info btn-sm juss"
                                               href="{{ route('backend.user.edit', $user->id) }}">
                                                <i class="fas fa-user-edit"></i> Sửa
                                            </a>
                                        @endcan
                                        @can('delete', $user)
                                            <form action="{{ route('backend.user.destroy', $user->id) }}"
                                                  method="POST"
                                                  style="display: inline">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit"
                                                        class="btn btn-danger btn-sm delete-confirm juss" {{ ($user->role == \App\Models\User::ROLE_MANAGE) ? 'disabled' : '' }}>
                                                    <i class="fas fa-eraser"></i> Xóa
                                                </button>
                                            </form>
                                        @endcan
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
                                <a href="{{ route('backend.user.export') }}" class="btn btn-sm btn-info d-inline-block"
                                   style="margin-right: 10px;">
                                    <i class="fas fa-file-export"></i> Export Excel
                                </a>
                                <form action="{{ route('backend.user.import') }}" method="POST" enctype="multipart/form-data" class="d-flex">
                                    @csrf
                                    <input class="form-control form-control-sm" id="formFileSm" type="file" name="file" accept=".xlsx" required>
                                    <button type="submit" class="btn btn-sm btn-info">Import</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="float-right mr-4">{!! $users->appends(request()->input())->links() !!}</div>
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
                icon: "error",
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

    <style>
        .table > :not(:last-child) > :last-child > * {
            border-bottom-color: #dee2e6;
        }
    </style>
@endsection
