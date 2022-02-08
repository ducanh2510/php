@extends('main')
@section('list-lesson-question')
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

                <a href="{{route('list_lesson')}}">Bài học</a>
                <span>Danh sách bài kiểm tra</span>
            </p>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Danh sách câu hỏi kiểm tra cuối bài học</h4>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            @if(isset($list_question))
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th class="col-md-1 text-center">Bài</th>
                                        <th class="col-md-1 text-center">Câu</th>
                                        <th class="col-md-5 text-center">Câu hỏi</th>
                                        <th class="col-md-1 text-center">Điểm</th>
                                        <th class="col-md-1 text-center">Xem</th>
                                        <th class="col-md-1 text-center">Chỉnh sửa</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($list_question) > 0)
                                        @foreach($list_question as $list)
                                            <tr>
                                                <td class="text-center">{{ $list->lesson_id }}</td>
                                                <td class="text-center">{{ $list->question_id }}</td>
                                                <td class="text-center">{{ $list->question }}</td>
                                                <td class="text-center">{{ $list->point }}</td>
                                                <td class="text-center"><a href="{{route('lesson_views_question_detail',[$list->course_id,$list->lesson_id,$list->question_id])}}"><i class="fas fa-eye"></i></a></td>
                                                <td class="text-center"><a href="{{route('lesson_update_question',[$list->course_id,$list->lesson_id,$list->question_id])}}"><i class="fas fa-pen-alt"></i></a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col-3 upload">
                                <a href="{{route('lesson_create_question',[$course_id, $lesson_id])}}">Thêm mới</a>
                            </div>
                            <div class="col-2"></div>
                            <div class="col-4 upload">
                                <a href="{{route('question_bank_lesson',[$course_id, $lesson_id])}}">Thêm từ ngân hàng câu hỏi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


