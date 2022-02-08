@extends('main')
@section('question-bank')
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/controll.css" type="text/css" media="all">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        .upload a{
            text-decoration: none;
            padding: 10px;
            background-color: dodgerblue;
            color: white;
        }
        #search{
            display: none;
        }
    </style>
    <div class="container" style="margin-top: 5%; margin-bottom: 5%">
        <div class="home">
            <p >
                <a href="{{route('home')}}"><i class="fas fa-home"></i>Trang chủ</a>
                <span>Ngân hàng câu hỏi</span>
            </p>
        </div>
        <div class="row">
            <div class="col-md-3 ">
                <div class="list-group ">
                    <p class="list-group-item list-group-item-action bg-success text-white " >Quản lí khóa học</p>
                    <a href="{{route('list_course')}}" class="list-group-item list-group-item-action ">Danh sách khóa học</a>
                    <a href="{{route('list_lesson')}}" class="list-group-item list-group-item-action ">Danh sách bài giảng</a>
                    <a href="{{route('question_bank')}}" class="list-group-item list-group-item-action active" >Ngân hàng câu hỏi</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Danh sách câu hỏi</h4>
                            </div>
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-2">
                                <p class="btn-primary text-white text-center" onclick="showForm()" style="padding: 8px"><i class="fas fa-search"></i> Tìm kiếm</p>
                            </div>
                            <hr>
                        </div>
                        <div class="row" id="search">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="keyword" class="col-4 col-form-label">Tìm kiếm theo môn học</label>
                                    <div class="col-4">
                                        <input type="text" class="form-control here" name="keyword" id="keyword">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-8 col-4" style="margin-top:1% ">
                                        <button class="btn btn-danger" id="btn2" onclick="hiddenForm()"><i class="fas fa-arrow-up"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div ></div>
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
                            @if(isset($list_question))
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center">MKH</th>
                                        <th class="text-center">MMH</th>
                                        <th class="text-center">Câu hỏi</th>
                                        <th class="text-center">Xem</th>
                                        @if(isset($course_id))
                                        <th class="text-center">Thêm</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody id="list_result">
                                    @if(count($list_question) > 0)
                                        @foreach($list_question as $list)
                                            <tr>
                                                <td class="text-center">{{ $list->course_id }}</td>
                                                <td class="text-center">{{ $list->subject_name }}</td>
                                                <td class="text-center">{{ $list->question }}</td>
                                                <td class="text-center"><a href="{{route('question_bank_views_detail',$list->id)}}"><i class="fas fa-eye"></i></a></td>
                                                @if(isset($course_id))
                                                    @if(!isset($lesson_id))
                                                        <form action="{{route('post_insert_question',[$course_id, $list->id])}}" method="post" enctype="multipart/form-data" >
                                                            @csrf
                                                            <td class="text-center">
                                                                <button type="submit" class="btn btn-primary"> Thêm</button>
                                                            </td>
                                                        </form>

                                                    @else
                                                        <form action="{{route('post_insert_lesson_question',[$course_id, $lesson_id, $list->id])}}" method="post" enctype="multipart/form-data" >
                                                            @csrf
                                                            <td class="text-center">
                                                                <button type="submit" class="btn btn-primary"> Thêm</button>
                                                            </td>
                                                        </form>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-5">
                            </div>
                            <div class="col-2">
                                {{$list_question->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showForm(){
            document.getElementById('search').style.display = "block";
        }
        function hiddenForm(){
            document.getElementById('search').style.display = "none";
        }
        $(document).ready(function(){

            $('#keyword').keyup(function(){ //bắt sự kiện keyup khi người dùng gõ từ khóa tim kiếm
                var query = $(this).val(); //lấy gía trị ng dùng gõ
                if(query != '') //kiểm tra khác rỗng thì thực hiện đoạn lệnh bên dưới
                {
                    var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
                    $.ajax({
                        url:"{{ route('search') }}", // đường dẫn khi gửi dữ liệu đi 'search' là tên route mình đặt bạn mở route lên xem là hiểu nó là cái j.
                        method:"get", // phương thức gửi dữ liệu.
                        data:{query:query, _token:_token},
                        success:function(data){ //dữ liệu nhận về
                            $('#list_result').fadeIn();
                            $('#list_result').html(data); //nhận dữ liệu dạng html và gán vào cặp thẻ có id là countryList
                        }
                    });
                }
            });

            $(document).on('click', 'li', function(){
                $('#keyword').val($(this).text());
                $('#list_result').fadeOut();
            });

        });
    </script>

@endsection
