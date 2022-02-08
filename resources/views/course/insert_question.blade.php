@extends('main')
@section('insert-question')
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        #course{
            display: none;
        }
        #lesson{
            display: none;
        }
    </style>
    <div class="container" style="margin-top: 5%; margin-bottom: 5%">
        <div class="home">
            <p style="font-size: 18px; margin-top: 1%; margin-bottom: 3%"><a href="{{route('home')}}"><i class="fas fa-home"></i>Trang chủ</a> > Danh sách khóa học</p>
        </div>
        <div class="row">
            <div class="col-md-3 ">
                <div class="list-group ">
                    <p class="list-group-item list-group-item-action bg-success text-white " >Quản lí khóa học</p>
                    <a href="{{route('list_course')}}" class="list-group-item list-group-item-action">Danh sách khóa học</a>
                    <a href="{{route('list_lesson')}}" class="list-group-item list-group-item-action ">Danh sách bài giảng</a>
                    <a href="{{route('question_bank')}}" class="list-group-item list-group-item-action active">Ngân hàng câu hỏi</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Thêm câu hỏi</h4>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{session('success')}}
                                    </div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{session('error')}}
                                    </div>
                                @endif
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <button id="course-btn" class="btn-primary text-white" onclick="showCourse()">Thêm vào bài kiểm tra khóa học</button>
                                <hr>
                            </div>
                        </div>
                        <div class="row" id="course">
                            <div class="data col-md-12">
                                <form action="{{route('post_insert_question',$id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="course_id" class="col-4 col-form-label">Nhập mã khóa học</label>
                                        <div class="col-4">
                                            <input type="text" class="form-control here" name="course_id">
                                            <span style="color: red">@error('course_id'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-4 col-8" style="margin-top:1% ">
                                            <button name="submit" type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Thêm</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="form-group row">
                                    <div class="offset-4 col-8" style="margin-top:1% ">
                                        <button class="btn btn-danger" id="btn1" onclick="hiddenCourse()"><i class="fas fa-arrow-up"></i></button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <button id="lesson-btn" class="btn-primary text-white" onclick="showLesson()">Thêm vào bài kiểm tra bài học</button>
                                <hr>
                            </div>
                        </div>
                        <div class="row" id="lesson">
                            <div class="data col-md-12">
                                <form action="{{route('post_insert_lesson_question', $id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="course_id" class="col-4 col-form-label">Nhập mã khóa học</label>
                                        <div class="col-4">
                                            <input type="text" class="form-control here" name="course_id">
                                            <span style="color: red">@error('course_id'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lesson_id" class="col-4 col-form-label">Bài học số</label>
                                        <div class="col-4">
                                            <input type="text" class="form-control here" name="lesson_id">
                                            <span style="color: red">@error('lesson_id'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-4 col-8" style="margin-top:1% ">
                                            <button name="submit" type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Thêm</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="form-group row">
                                    <div class="offset-4 col-8" style="margin-top:1% ">
                                        <button class="btn btn-danger" id="btn2" onclick="hiddenLesson()"><i class="fas fa-arrow-up"></i></button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showCourse(){
            document.getElementById('course').style.display = "block";
        }
        function hiddenCourse(){
            document.getElementById('course').style.display = "none";
        }
        function showLesson(){
            document.getElementById('lesson').style.display = "block";
        }
        function hiddenLesson(){
            document.getElementById('lesson').style.display = "none";
        }
    </script>
@endsection
