@extends('main')
@section('show-test-result')
    <style>
        #back{
            text-decoration: none;
        }
        #back:hover{
            background-color: orangered;
            color: white;
        }
    </style>
    <link rel="stylesheet" href="/css/course/show_test.css" type="text/css">
    <div class="content">
        <div class="text-center advertisement">
            <img src="/image/qc.jpg" alt="quảng cáo">
        </div>
        <div class="title">
            <h3 class="text-center" >KHÓA HỌC {{$course_id}}</h3>
        </div>

        <div class="result mt-5">
            <h5 class="text-center text-primary"> CHÚC MỪNG BẠN ĐÃ HOÀN THÀNH BÀI KIỂM TRA VỚI ĐIỂM SỐ : {{$total_point}} / {{$max_point}}</h5>
        </div>
        <div class="row mt-5">
            <div class="col-4 text-center">
                <img src="/image/hoadiem10.png" style="width: 100%; height: auto" alt="Chúc mừng bạn">
            </div>
            <div class="col-4 text-center mt-5">
                <a href="{{route('views_course',$slug->slug)}}" class="btn-primary p-2" id="back"> Trở về khóa học</a>
            </div>
            <div class="col-4 text-center">
                <img src="/image/hoadiem10.png" style="width: 100%; height: auto" alt="Chúc mừng bạn">
            </div>
        </div>
    </div>

@endsection
