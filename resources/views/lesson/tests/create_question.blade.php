@extends('main')
@section('create-lesson-question')
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/controll.css" type="text/css" media="all">

    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'summary-ckeditor' );
    </script>
    <div class="container" style="margin-top: 5%; margin-bottom: 5%">
        <div class="home">
            <p>
                <a href="{{route('home')}}"><i class="fas fa-home"></i>Trang chủ</a>

                <a href="{{route('list_lesson')}}">Bài học</a>

                <a href="{{route('lesson_list_question',[$course_id, $lesson_id])}}">Danh sách câu hỏi</a>
                <span>Tạo câu hỏi</span>
            </p>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Tải lên câu hỏi</h4>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{route('lesson_post_create_question',[$course_id, $lesson_id])}}" method="post" enctype="multipart/form-data">
                                    @csrf
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
                                    <div class="form-group row">
                                        <label for="course_id" class="col-4 col-form-label">Mã khóa học</label>
                                        <div class="col-8">
                                            <p class="text-center">{{$course_id}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="id" class="col-4 col-form-label">Bài học số </label>
                                        <div class="col-8">
                                            <p class="text-center">{{$lesson_id}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="question_id" class="col-4 col-form-label">Câu hỏi số </label>
                                        <div class="col-8">
                                            <input name="question_id" class="form-control here" type="text">
                                            <span style="color: red">@error('question_id'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="question" class="col-4 col-form-label">Nội dung câu hỏi</label>
                                        <div class="col-8">
                                            <input  name="question" class="form-control here" type="text">
                                            <span style="color: red">@error('question'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="choose_1" class="col-4 col-form-label">Đáp án A</label>
                                        <div class="col-8">
                                            <input  name="choose_1" class="form-control here" type="text">
                                            <span style="color: red">@error('choose_1'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="choose_2" class="col-4 col-form-label">Đáp án B </label>
                                        <div class="col-8">
                                            <input  name="choose_2" class="form-control here" type="text">
                                            <span style="color: red">@error('choose_2'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="choose_3" class="col-4 col-form-label">Đáp án C </label>
                                        <div class="col-8">
                                            <input  name="choose_3" class="form-control here" type="text">
                                            <span style="color: red">@error('choose_3'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="choose_4" class="col-4 col-form-label">Đáp án D </label>
                                        <div class="col-8">
                                            <input  name="choose_4" class="form-control here" type="text">
                                            <span style="color: red">@error('choose_4'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="answer" class="col-4 col-form-label">Đáp án chính xác </label>
                                        <div class="col-8">
                                            <select id="select" name="answer"  class="custom-select">
                                                <option value=""></option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>
                                            <span style="color: red">@error('answer'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="point" class="col-4 col-form-label">Điểm cho câu hỏi </label>
                                        <div class="col-8">
                                            <input  name="point" class="form-control here" type="text">
                                            <span style="color: red">@error('point'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-4 col-8" style="margin-top:1% ">
                                            <button name="submit" type="submit" class="btn btn-primary">Tải lên</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection