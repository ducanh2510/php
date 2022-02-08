@extends('main')
@section('show-test')
    <link rel="stylesheet" href="/css/course/show_test.css" type="text/css">

<div class="content">
    <div class="text-center advertisement">
        <img src="/image/qc.jpg" alt="quảng cáo">
    </div>
    <div class="title">
        <h3 class="text-center" >KHÓA HỌC {{$result[0]->course_id}}</h3>
    </div>
    <div class="test mt-5">
        <h5 class="text-center">Bài kiểm tra cuối khóa học</h5>
        <h6 class="text-center">Số lượng câu hỏi: {{$count[0]->number}}</h6>
        <input type="hidden" value="{{$count[0]->number}}" id="number">
        <h6 class="text-center">Thời gian làm bài: 10 phút</h6>
        <h6 class="text-center">Hãy làm bài thật cố gắng để kiếm những bông hoa điểm 10.</h6>
        <h6 class="text-center">Chúc bạn may mắn :3</h6>
    </div>
    <div class="ready mt-4" id="ready">
        <p class="text-center text-danger"> Click để bắt đầu làm bài</p>
        <p class="text-center text-danger"><i class="fas fa-arrow-down"></i></p>
        <p class="col-sm-2 btn-primary m-auto pt-2 pb-2 text-center" id="start" onclick="show()">BẮT ĐẦU LÀM BÀI</p>
    </div>
    <div class="m-lg-5" id="ok">
        <h6 class="text-danger">CHỌN MỘT ĐÁP ÁN ĐÚNG CHO MỖI CÂU HỎI DƯỚI ĐÂY:</h6>
        <form action="{{route('check_answer',$result[0]->course_id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @foreach($result as $item)
                <div class="form-group mt-3 ml-4" id="quiz" style=" clear: both">

                    <h6>
                        <span>Câu {{$item->id}}</span>
                        <span>: {{$item->question}}</span>
                    </h6>
                    <input type="radio" name="choose{{$item->id}}" value="A">
                    <label for="choose_1">{{$item->choose_1}}</label><br>
                    <input type="radio" name="choose{{$item->id}}" value="B">
                    <label for="choose_2">{{$item->choose_2}}</label><br>
                    <input type="radio" name="choose{{$item->id}}" value="C">
                    <label for="choose_3">{{$item->choose_3}}</label><br>
                    <input type="radio" name="choose{{$item->id}}" value="D">
                    <label for="choose_4">{{$item->choose_4}}</label>
                </div>
            @endforeach
            <div class="form-group row">
                <div class="offset-5 col-8" style="margin-top:1% ">
                    <button name="submit" type="submit" class="btn btn-primary">Nộp bài</button>
                </div>
            </div>
        </form>
    </div>
</div>
    <script type="text/javascript">
        function show(){
            document.getElementById('ok').style.display= "block";
            document.getElementById('ready').style.display="none";
        }
    </script>
@endsection
