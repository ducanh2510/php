@extends('main')
@section('views-lesson-question-detail')
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
        <p >
            <a href="{{route('home')}}"><i class="fas fa-home"></i>Trang chủ</a>

            <a href="{{route('list_lesson')}}">Bài học</a>

            <a href="{{route('lesson_list_question',[ $result->course_id,$result->lesson_id])}}"> Danh sách câu hỏi</a>
             <span>Chi tiết câu hỏi</span>
        </p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Chi tiết câu hỏi</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="course_id" class="col-4 col-form-label">Mã khóa học</label>
                                <div class="col-8">
                                    <p class="text-center text-primary">{{$result->course_id}}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lesson_id" class="col-4 col-form-label">Bài học</label>
                                <div class="col-8">
                                    <p class="text-center text-primary">{{$result->lesson_id}}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="question_id" class="col-4 col-form-label">Câu hỏi số </label>
                                <div class="col-8">
                                    <p class="text-center text-primary">{{$result->question_id}}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="question" class="col-4 col-form-label">Nội dung câu hỏi</label>
                                <div class="col-8">
                                    <p class="text-center text-primary">{{$result->question}}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="choose_1" class="col-4 col-form-label">Đáp án A</label>
                                <div class="col-8">
                                    <p class="text-center text-primary">{{$result->choose_1}}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="choose_2" class="col-4 col-form-label">Đáp án B </label>
                                <div class="col-8">
                                    <p class="text-center text-primary">{{$result->choose_2}}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="choose_3" class="col-4 col-form-label">Đáp án C </label>
                                <div class="col-8">
                                    <p class="text-center text-primary">{{$result->choose_3}}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="choose_4" class="col-4 col-form-label">Đáp án D </label>
                                <div class="col-8">
                                    <p class="text-center text-primary">{{$result->choose_4}}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="answer" class="col-4 col-form-label">Đáp án chính xác </label>
                                <div class="col-8">
                                    <p class="text-center text-primary">{{$result->answer}}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="point" class="col-4 col-form-label">Điểm cho câu hỏi </label>
                                <div class="col-8">
                                    <p class="text-center text-primary">{{$result->point}}</p>
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
