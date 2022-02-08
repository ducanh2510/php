@extends('main')
<link rel="stylesheet" href="/css/course/course_view.css" type="text/css">
<link rel="stylesheet" href="/css/controll.css" type="text/css" media="all">

<style>
    #error{
        display: none;
    }
</style>
@section('course_views')
<?php use Illuminate\Support\Facades\DB;?>
    <div class="container" style="margin-top: 3%">
        <div class="text-center">
            <img src="/image/qc.jpg" alt="quảng cáo">
        </div>
        <div class="course-name">
            <h3>{{$course->course_name}}</h3>
        </div>
        <div class="video">
            <video width="1120" height="540" controls >
                <source src="/movie/{{$course->video}}" type="video/mp4">
            </video>
        </div>

        <div class="description">
            <h6>Mô tả khóa học</h6>
            <br>
            <p>
                {{$course->description}}
            </p>

        </div>
        <div class="requirements">
            <h6>Yêu cầu của khóa học</h6>
            <br>
            <p>
                {{$course->requirements}}
            </p>
        </div>
        <div class="outcomes">
            <h6>Kết quả sau khóa học</h6>
            <br>
            <p>
                {{$course->outcomes}}
            </p>
        </div>
        <div class="row">
            <div class="col-md-10">
                <p>Bài giảng<i class="fas fa-caret-down"></i></p>
                <?php $count_check = 0;
                ?>
                @foreach($lessons as $lesson)
                    <?php $check_exits = DB::table('lesson_achievements')
                        ->where('username',auth()->user()->username)
                        ->where('course_id',$lesson->course_id)
                        ->where('lesson_id',$lesson->lesson_id)
                        ->exists(); ?>
                    @if($check_exits == true)
                        <?php $count_check += 1; ?>
                        <div class="lesson">
                            <p class ="titles"><i class="far fa-check-circle text-danger"></i>Bài {{$lesson->lesson_id}} : {{$lesson->lesson_name}}</p>
                            <div class ="col-12">
                                <ul>
                                    <li>
                                        <a onclick="saveHistory('{{$lesson->course_id}}', '{{$lesson->slug}}')" href="{{route('lesson_views',$lesson->slug)}}" class="video"><i class="fas fa-play-circle"></i>Video bài học</a>
                                    </li>
                                    <li>
                                        <p style="background-color: white; border: none" class="text-primary"><i class="fas fa-check-circle text-danger"></i>Bài kiểm tra: <span class="text-danger">Đã hoàn thành !</span></p>
                                        <hr>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @else
                            <div class="lesson">
                                <p class ="titles"><i class="far fa-circle"></i>Bài {{$lesson->lesson_id}} : {{$lesson->lesson_name}}</p>
                                <div class ="col-12">
                                    <ul>
                                        <li>
                                            <a onclick="saveHistory('{{$lesson->course_id}}', '{{$lesson->slug}}')" href="{{route('lesson_views',$lesson->slug)}}" class="video"><i class="fas fa-play-circle"></i>Video bài học</a>
                                        </li>
                                        <li>
                                            <a href="{{route('lesson_test',[$lesson->course_id, $lesson->lesson_id])}}" class="test"><i class="fal fa-stop"></i>Làm bài kiểm tra</a>
                                            <hr>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                    @endif
                @endforeach
                <?php $check_final_test_exits = DB::table('course_achievements')
                    ->where('username',auth()->user()->username)
                    ->where('course_id','=',$lesson->course_id)
                    ->get()->first();
                //dd($check_final_test_exits);
                ?>
                @if(isset($check_final_test_exits))
                    @if($check_final_test_exits->final_score != null)
                        <p style="background-color: white; border: none" class="text-primary">
                            <i style="float: left" class="far fa-check-square text-danger mr-3"></i>
                            Bài kiểm tra cuối khóa :
                            <span class="text-danger"> Đã hoàn thành</span>
                        </p>
                    @else
                        <a class="final-test" style="text-decoration: none;" href="{{route('course_final_test',[$course->course_id, $count_check])}}">
                            <i class="far fa-square"></i>Kiểm tra sau khóa học
                        </a>
                            @if(session('test_error'))
                                <div class="alert alert-danger">
                                    {{session('test_error')}}
                                </div>
                            @endif
                    @endif
                @else
                    <a class="final-test" style="text-decoration: none;" href="{{route('course_final_test',[$course->course_id, $count_check])}}">
                        <i class="far fa-square"></i>Kiểm tra sau khóa học
                    </a>
                    @if(session('test_error'))
                        <div class="alert alert-danger">
                            {{session('test_error')}}
                        </div>
                    @endif
                @endif

            </div>
        </div>
        <div class="col-md-10" style="margin-top: 5%">
            <div class="well">
                <h4 style="margin: 2%; padding-top: 3%">Comments...   <i class="fas fa-pencil-alt"></i></h4>
                <form action="/BK-E-learning/Course/view/{{$course->course_id}}/Create-comment" role="form" method="post" style="margin: 2%; padding-bottom: 2%">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <input type="text" name="commentString" placeholder="Input comment..." class ="col-12" style="border-radius: 12px 12px; height: 40px;">
                    </div>
                    <button type="submit" style="display: none" id="makeComment" class="btn btn-primary">Submit</button>
                </form>
            </div>
            @foreach($list_comment as $comment)
                <div class ="col-12" style="display: flex; align-items: center; margin-top: 2%; margin-bottom: 2%; background-color: #f7fcfc">
                    <div class ="col-1" style="display: inline-block;"><i class="far fa-user fa-3x"></i></div>
                    <div style="margin-left: 2%; width: 100%">
                        <div>
                            <span>{{$comment->username}}</span>
                            <span style="margin-left: 2%; color: #AAAAAA; font-size: 10px"><?php echo date("d-m-Y") ?></span>
                        </div>
                        <div ><h5>{{$comment->commentString}}</h5></div>
                        <div>
                            <span class="react likeReact">
                                <i class="fas fa-thumbs-up">{{$comment->like}}</i>
                            </span>
                            <span class="react dislikeReact">
                                <i class="fas fa-thumbs-down">{{$comment->dislike}}</i>
                            </span>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
<script>
    function show(){
        document.getElementById('error').style.display = "block";
    }
    const csrf = '{{csrf_token()}}';
    function saveHistory(couserId, lessonSlug) {
        const params = {
            'course_id': couserId,
            'lession_slug': lessonSlug,
            '_token': csrf
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            type: "POST",
            url: '/history',
            data: params,
            success: function(data) {
                console.log(data);
            },
        });
    }
</script>
@endsection

