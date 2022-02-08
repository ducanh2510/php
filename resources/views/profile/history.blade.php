@extends('main')
@section('history')
    <link rel="stylesheet" href="/css/controll.css" type="text/css" media="all">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <div class="container" style="margin: 3% auto">
        <div class="home">
            <p >
                <a href="{{route('home')}}"><i class="fas fa-home"></i>Trang chủ</a>
                <span>Profile</span>
            </p>
        </div>
        <div class="row">
            <div class="col-md-3 ">
                <div class="list-group ">
                    <a href="{{route('profile')}}" style="background-color: forestgreen" class="text-white list-group-item list-group-item-action">THÔNG TIN CÁ NHÂN</a>
                    <a href="{{route('update_profile')}}" class="list-group-item list-group-item-action">Cập nhật thông tin</a>
                    <a href="{{route('change_password')}}" class="list-group-item list-group-item-action">Thay đổi mật khẩu</a>
                    <a href="{{route('history')}}" class="list-group-item list-group-item-action active">Lịch sử khóa học</a>
                    <a href="#" class="list-group-item list-group-item-action">Các chứng chỉ đạt được</a>
                </div>
            </div>
            @if(isset(auth()->user()->username))
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Lịch sử khóa học</h4>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Tên khóa học</th>
                                            <th scope="col">Tên bài giảng hiện tại</th>
                                            <th scope="col">Ngày xem</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($histories->items() as $history)
                                            <tr>
                                                <th scope="row">{{$history->id}}</th>
                                                <td><p target="_blank" href="{{route('views_course',$history->course->slug)}}">{{$history->course->course_name}}</p></td>
                                                <td><a target="_blank" href="{{route('lesson_views',$history->lesson->slug)}}">Bài {{$history->lesson->lesson_id}}: {{$history->lesson->lesson_name}}</a></td>
                                                <td>{{$history->created_at}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-end">
                                        {{$histories->links("pagination::bootstrap-4")}}
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
