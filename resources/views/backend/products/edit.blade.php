{{-- @dd($categories) --}}
@extends('backend.layouts.master')

@section('title')
    Thay đổi thông tin sản phẩm
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
                        <h3 class="card-title">Thay đổi thông tin sản phẩm</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('backend.product.update', $product->id) }}" method="POST"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên sản phẩm</label>
                                <input type="text" class="form-control" id="" name="name" value="{{ $product->name }}">

                                @error('name')
                                <p style="color: red;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Danh mục sản phẩm</label>
                                <select class="form-control select2" name="category_id" style="width: 100%;" id="category" onchange="getTrademark()">
                                    <option value="0">-- Chọn danh mục --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                        @if($category->id == $product->category_id)
                                            {{ 'selected' }}
                                            @endif
                                        >{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Thương hiệu</label>
                                <select class="form-control select2" name="trademark_id" style="width: 100%;" id="trademark">
                                    <option value="0">-- Chọn thương hiệu --</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Giá gốc</label>
                                        <input type="text" class="form-control" name="origin_price"
                                               value="{{ $product->origin_price }}" min="0" step="1">

                                        @error('origin_price')
                                        <p style="color: red;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Giá bán</label>
                                        <input type="text" class="form-control" name="sale_price"
                                               value="{{ $product->sale_price }}" min="0" step="1">

                                        @error('sale_price')
                                        <p style="color: red;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả sản phẩm</label>
                                <textarea class="" id="editor_content" name="content"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{!! $product->content !!}</textarea>

                                @error('content')
                                <p style="color: red;">{{ $message }}</p>
                                @enderror
                            </div>
                            <style>
                                #buu {
                                    display: flex;
                                    flex-wrap: wrap;
                                    flex-direction: column;
                                }

                                #buu > img {
                                    width: 250px;
                                    height: 200px;
                                    margin-right: 20px;
                                }

                                #boxImg {
                                    display: flex;
                                    flex-wrap: wrap;
                                    flex-direction: row;
                                }

                                .gallery > img {
                                    width: 250px;
                                    margin-right: 20px;
                                }
                            </style>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="d-block">Xóa hình ảnh</label>
                                <div id="boxImg">
                                    @foreach($product->images as $image)
                                        <div id="buu">
                                            <img src="{{ $image->image_url}}" class="rounded float-start d-block"
                                                 alt="...">
                                            <div class="d-flex justify-content-center" style="margin-top: 10px;">
                                                <input class="" type="checkbox" name="delete_img[]"
                                                       value="{{ $image->id }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Hình ảnh sản phẩm</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="listImg" accept="image/*"
                                               name="image[]" multiple>
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">Upload</span>
                                    </div>
                                </div>
                                <div class="gallery d-flex flex-wrap" style="margin-top: 20px;"></div>
                                @error('image[]')
                                <p style="color: red;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Trạng thái sản phẩm</label>
                                <select class="form-control select2" name="status" style="width: 100%;">
                                    @foreach(\App\Models\Product::$status_text as $key => $value)
                                        <option value="{{ $key }}"
                                                @if($product->status == $key)
                                                selected
                                            @endif
                                        >{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="clone">
                                <label for="">Thông số kỹ thuật</label>
                                @if(!empty($product->content_more_json))
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach($product->content_more_json as $key => $value)
                                        @php
                                            $i++;
                                        @endphp
                                        <div class="row" id="row{{ $i }}">
                                            <div class="col-4 col-lg-2">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="" name="key[]"
                                                           value="{{ $key }}">
                                                </div>
                                            </div>
                                            <div class="col-8 col-lg-10">
                                                <div class="form-group" style="position: relative;">
                                                    <input type="text" class="form-control" id="" name="val[]"
                                                           value="{{ $value }}">
                                                    <span
                                                        class="btn btn-sm btn-danger closee d-flex align-items-center justify-content-center"
                                                        id="{{ $i }}"
                                                        style="position: absolute; right: 0; top: 0; height: 100%; cursor: pointer;">Close</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <span id="tes" class="btn btn-sm btn-warning">Thêm</span>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <a href="{{ route('backend.product.index') }}" class="btn btn-danger">Huỷ bỏ</a>
                            <button type="submit" class="btn btn-success">Thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function () {
                @if(!empty($product->content_more_json))
                var i = {{ count($product->content_more_json) }};
                @else
                var i = 0;
                @endif

                $("#tes").click(function () {
                    i++;
                    $('#clone').append('<div class="row" id="row' + i + '">' +
                        '<div class="col-4 col-lg-2"><div class="form-group">' +
                        '<input type="text" class="form-control" id="" name="key[]" value="">' +
                        '</div></div><div class="col-8 col-lg-10">' +
                        '<div class="form-group" style="position: relative;">' +
                        '<input type="text" class="form-control" id="" name="val[]" value="">' +
                        '<span class="btn btn-sm btn-danger closee d-flex align-items-center justify-content-center" id="' + i + '" style="position: absolute; right: 0; top: 0; height: 100%; cursor: pointer;">Xóa</span>' +
                        '</div></div></div>')
                });

                $(document).on('click', '.closee', function () {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });

                getTrademark();
                function getTrademark(){
                    var id = {{ $product->category_id }};
                    var id_trade = {{ $product->trademark_id }};
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route('backend.product.trademark') }}',
                        method: 'POST',
                        dataType: 'JSON',
                        data: {id: id, _token: _token},
                        success: function (data) {
                            $('#trademark').empty();
                            var i = 0;
                            $('#trademark').append(
                                '<option value="0">-- Chọn thương hiệu --</option>'
                            );
                            $.each(data, function () {
                                if({{ $product->trademark_id }} == data[i].id){
                                    $('#trademark').append(
                                    '<option value="'+ data[i].id +'" selected>'+ data[i].name +'</option>'
                                );
                                }else{
                                    $('#trademark').append(
                                    '<option value="'+ data[i].id +'">'+ data[i].name +'</option>'
                                );
                                }
                                
                                i++;
                            });
                        }
                    });
                }
                $('#category').change(function (){
                    var id = $('select[name=category_id] option').filter(':selected').val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route('backend.product.trademark') }}',
                        method: 'POST',
                        dataType: 'JSON',
                        data: {id: id, _token: _token},
                        success: function (data) {
                            $('#trademark').empty();
                            var i = 0;
                            $('#trademark').append(
                                '<option value="0">-- Chọn thương hiệu --</option>'
                            );
                            $.each(data, function () {
                                $('#trademark').append(
                                    '<option value="'+ data[i].id +'">'+ data[i].name +'</option>'
                                );
                                i++;
                            });
                        }
                    });
                });
            });

            function previewImages() {
                var preview = document.querySelector('.gallery');

                if (this.files) {
                    [].forEach.call(this.files, readAndPreview);
                }

                function readAndPreview(file) {
                    if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
                        return alert(file.name + " is not an image");
                    }

                    var reader = new FileReader();

                    reader.addEventListener("load", function () {
                        var image = new Image();
                        image.title = file.name;
                        image.src = this.result;

                        preview.appendChild(image);
                    });

                    reader.readAsDataURL(file);

                }
            }

            document.querySelector('#listImg').addEventListener("change", previewImages);
        </script>
    </div>
@endsection
