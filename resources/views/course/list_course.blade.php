@extends('main')
@section('list-course')
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/controll.css" type="text/css" media="all">

    <style>
        .upload a{
            text-decoration: none;
            padding: 10px;
            background-color: dodgerblue;
            color: white;
        }
    </style>
    <div class="container" style="margin-top: 5%; margin-bottom: 5%">
        <div class="home">
            <p >
                <a href="{{route('home')}}"><i class="fas fa-home"></i>Trang chủ</a>
                <span>Danh sách khóa học</span>
            </p>
        </div>
        <div class="row">
            <div class="col-md-3 ">
                <div class="list-group ">
                    <p class="list-group-item list-group-item-action bg-success text-white " >Quản lí khóa học</p>
                    <a href="{{route('list_course')}}" class="list-group-item list-group-item-action active ">Danh sách khóa học</a>
                    <a href="{{route('list_lesson')}}" class="list-group-item list-group-item-action ">Danh sách bài giảng</a>
                    <a href="{{route('question_bank')}}" class="list-group-item list-group-item-action">Ngân hàng câu hỏi</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Danh sách khóa học</h4>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            @if(isset($list_course))
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Mã khóa học</th>
                                        <th class="text-center">Môn học</th>
                                        <th class="text-center">Tên khóa học</th>
                                        <th class="text-center">Test</th>
                                        <th class="text-center">View</th>
                                        <th class="text-center">Edit</th>
                                        <th class="text-center">Create</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($list_course) > 0)
                                        @foreach($list_course as $list)
                                            <tr>
                                                <td class="text-center">{{ $list->course_id }}</td>
                                                <td class="text-center">{{ $list->subject_name }}</td>
                                                <td class="text-center">{{ $list->course_name }}</td>
                                                <td class="text-center"><a href="{{route('list_question', $list->course_id)}}"><i class="fas fa-file-alt"></i></a></td>
                                                <td class="text-center"><a href="{{route('course_views_detail',$list->slug)}}"><i class="fas fa-eye"></i></a></td>
                                                <td class="text-center"><a href="{{route('update_course', $list->slug)}}"><i class="fas fa-pen-alt"></i></a></td>
                                                <td class="text-center"><a href="{{route('upload_lesson',[$list->course_id, $list->subject_name])}}"><i class="fas fa-folder-plus"></i></a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td>No result found!</td></tr>
                                    @endif
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-5">
                            </div>
                            <div class="col-2 upload">
                                <a href="{{route('upload_course')}}">Thêm mới</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

