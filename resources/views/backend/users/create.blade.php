@extends('backend.layouts.master')

@section('title')
    Tạo mới người dùng
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
					<h3 class="card-title">Tạo mới người dùng</h3>
				</div>
				<!-- /.card-header -->
				<!-- form start -->
				<form role="form" action="{{ route('backend.user.store') }}" method="POST">
                    @csrf
					<div class="card-body">
						<div class="form-group">
							<label for="exampleInputEmail1">Họ tên</label>
							<input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Tên người dùng">

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
							<input type="number" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại">

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
                            <label for="exampleInputEmail1">Mật khẩu</label>
                            <input type="password" class="form-control" name="password" placeholder="Mật khẩu">

                            @error('password')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
						<div class="form-group">
							<label>Quyền</label>
							<select class="form-control select2" name="role" style="width: 100%;">
								@foreach(\App\Models\User::$role_text as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
							</select>
						</div>
					</div>
					<!-- /.card-body -->

					<div class="card-footer">
                        <a href="{{ route('backend.user.index') }}" class="btn btn-danger">Huỷ bỏ</a>
						<button type="submit" class="btn btn-success">Tạo mới</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /.row (main row) -->
</div>
@endsection
