@extends('main')
@section('list-lesson')
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
                <span>Danh sách bài giảng</span>
            </p>
        </div>
        <div class="row">
            <div class="col-md-3 ">
                <div class="list-group ">
                    <p class="list-group-item list-group-item-action bg-success text-white " >Quản lí khóa học</p>
                    <a href="{{route('list_course')}}" class="list-group-item list-group-item-action ">Danh sách khóa học</a>
                    <a href="{{route('list_lesson')}}" class="list-group-item list-group-item-action active ">Danh sách bài giảng</a>
                    <a href="{{route('question_bank')}}" class="list-group-item list-group-item-action">Ngân hàng câu hỏi</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Danh sách bài giảng</h4>
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
                                    <label for="keyword" class="col-4 col-form-label">Tìm kiếm theo khóa học</label>
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
                            @if(isset($list_lesson))
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Khóa học</th>
                                        <th class="text-center">Bài</th>
                                        <th class="text-center">Tên bài giảng</th>
                                        <th class="text-center">Test</th>
                                        <th class="text-center">View</th>
                                        <th class="text-center">Edit</th>
                                    </tr>
                                    </thead>
                                    <tbody id="list_result">
                                    @if(count($list_lesson) > 0)
                                        @foreach($list_lesson as $list)
                                            <tr>
                                                <td class="text-center">{{ $list->course_name }}</td>
                                                <td class="text-center">{{ $list->lesson_id }}</td>
                                                <td class="text-center">{{ $list->lesson_name }}</td>
                                                <td class="text-center"><a href="{{route('lesson_list_question', [$list->course_id, $list->lesson_id])}}"><i class="fas fa-file-alt"></i></a></td>
                                                <td class="text-center"><a href="{{route('lesson_views_detail',$list->slug)}}"><i class="fas fa-eye"></i></a></td>
                                                <td class="text-center"><a href="{{route('update_lesson',$list->slug)}}"><i class="fas fa-pen-alt"></i></a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td>No result found!</td></tr>
                                    @endif
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-5">
                            </div>
                            <div class="col-2">
                                {{$list_lesson->links()}}
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
                        url:"{{ route('lesson_search') }}", // đường dẫn khi gửi dữ liệu đi 'search' là tên route mình đặt bạn mở route lên xem là hiểu nó là cái j.
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
@stop

