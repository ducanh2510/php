@extends('main')
@section('documents-views-detail')
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/controll.css" type="text/css" media="all">

    <div class="container" style="margin-top: 5%; margin-bottom: 5%">
        <div class="home">
            <p><a href="{{route('home')}}"><i class="fas fa-home"></i>Trang chủ</a>

                <a href="{{route('list_documents')}}">Tài liệu</a>
                <span>Chi tiết tài liệu</span>
            </p>
        </div>
        <div class="row">
            <div class="col-md-3 ">
                <div class="list-group ">
                    <p class="list-group-item list-group-item-action bg-success text-white ">Quản lí tài liệu</p>
                    <a href="{{route('list_documents')}}" class="list-group-item list-group-item-action  ">Danh sách tài liệu</a>
                    <a href="{{route('upload_documents')}}" class="list-group-item list-group-item-action ">Thêm mới</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Chi tiết</h4>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            @if(isset($result))
                                <div class="col-md-12" >
                                    <div class="form-group row">
                                        <label for="subject_name" class="col-2 col-form-label">Tên môn học </label>
                                        <div class="col-10">
                                            <p class="text-center text-danger"> {{$result->subject_name}} </p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="document_id" class="col-2 col-form-label">Mã tài liệu</label>
                                        <div class="col-10">
                                            <p class="text-center text-danger"> {{$result->document_id}} </p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="grade" class="col-2 col-form-label">Khối lớp </label>
                                        <div class="col-10">
                                            <p class="text-center text-danger"> {{$result->grade}} </p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="title" class="col-2 col-form-label">Tiêu đề </label>
                                        <div class="col-10">
                                            <p class="text-center text-danger"> {{$result->title}} </p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="title" class="col-2 col-form-label">Tài liệu </label>
                                        <div class="col-10">
                                            <p class="text-center text-danger"> {{$result->content}} </p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="author" class="col-2 col-form-label">Tác giả</label>
                                        <div class="col-10">
                                            <p class="text-center text-danger"> {{$result->author}} </p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="slug" class="col-2 col-form-label">Link tài liệu</label>
                                        <div class="col-10">
                                            <p class="text-center text-danger"> {{$result->slug}} </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

