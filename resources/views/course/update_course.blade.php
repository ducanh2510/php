@extends('main')
@section('update-course')
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/controll.css" type="text/css" media="all">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'summary-ckeditor' );
    </script>
    <div class="container" style="margin-top: 5%; margin-bottom: 5%">
        <div class="home">
            <p >
                <a href="{{route('home')}}"><i class="fas fa-home"></i>Trang chủ</a>
                <span>Cập nhật khóa học </span>
            </p>
        </div>
        <div class="row">
            <div class="col-md-3 ">
                <div class="list-group ">
                    <p class="list-group-item list-group-item-action bg-success text-white ">Quản lí khóa học</p>
                    <a href="{{route('list_course')}}" class="list-group-item list-group-item-action ">Danh sách khóa học</a>
                    <a href="{{route('list_lesson')}}" class="list-group-item list-group-item-action ">Danh sách bài giảng</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Cập nhật khóa học</h4>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            @if(isset($course))
                                <div class="col-md-12" >
                                    <form action="{{route('post_update_course',[$course->course_id, $course->subject_name])}}" method="post" enctype="multipart/form-data">
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
                                            <label for="course_name" class="col-4 col-form-label">Tên khóa học</label>
                                            <div class="col-8">
                                                <input name="course_name" class="form-control here" value="{{$course->course_name}}" type="text">
                                                <span style="color: red">@error('course_name'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="course_id" class="col-4 col-form-label">Mã khóa học </label>
                                            <div class="col-8">
                                                <p class="text-primary">{{$course->course_id}}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="subject_name" class="col-4 col-form-label">Môn học </label>
                                            <div class="col-8">
                                                <p class="text-primary">{{$course->subject_name}}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="grade" class="col-4 col-form-label">Khối lớp</label>
                                            <div class="col-8">
                                                <input name="grade" class="form-control here" value="{{$course->grade}}" type="text">
                                                <span style="color: red">@error('grade'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-4 col-form-label">Mô tả khóa học </label>
                                            <div class="col-8" >
                                                <textarea class="form-control summary-ckeditor" name="description"></textarea>
{{--                                                <input name="description" class="form-control here" value="{{$course->description}}" type="text">--}}
                                                <span style="color: red">@error('description'){{$message}}@enderror</span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="requirements" class="col-4 col-form-label">Yêu cầu của môn học</label>
                                            <div class="col-8" >
                                                <textarea class="form-control summary-ckeditor" name="requirements" ></textarea>
{{--                                                <input name="requirements" class="form-control here" value="{{$course->requirements}}" type="text">--}}
                                                <span style="color: red">@error('requirements'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="outcomes" class="col-4 col-form-label">Kết quả đạt được</label>
                                            <div class="col-8" >
                                                <textarea class="form-control summary-ckeditor" name="outcomes"></textarea>
{{--                                                <input name="outcomes" class="form-control here" value="{{$course->outcomes}}" type="text">--}}
                                                <span style="color: red">@error('outcomes'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="slug" class="col-4 col-form-label">Liên kết</label>
                                            <div class="col-8">
                                                <input name="slug" class="form-control here" value="{{$course->slug}}" type="text">
                                                <span style="color: red">@error('slug'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="des_image" class="col-4 col-form-label">Ảnh hiện tại</label>
                                            <img width="320" height="240" src="/image/{{$course->des_image}}" alt="ảnh khóa học">

                                            <input style="border: none; outline: none; background-color: white"  type="text"  name="current_des_image" value="{{$course->des_image}}">
                                        </div>
                                        <div class="form-group row">
                                            <div class="custom-file ">
                                                <label for="update_des_image" class="col-4 col-form-label">Cập nhật ảnh mô tả</label>
                                                <input type="file" name="update_des_image">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="current_video" class="col-4 col-form-label">Video hiện tại</label>
                                            <video width="320" height="240" controls >
                                                <source src="/movie/{{$course->video}}" type="video/mp4">
                                            </video>
                                            <input style="border: none; outline: none; background-color: white"  type="text" name="current_video" value="{{$course->video}}">
                                        </div>
                                        <div class="form-group row">
                                            <div class="custom-file ">
                                                <label for="upldate_video" class="col-4 col-form-label">Cập nhật video</label>
                                                <input type="file" name="update_video" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-4 col-8" style="margin-top:1% ">
                                                <button name="submit" type="submit" class="btn btn-primary">Cập nhật</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

