@extends('library.main_library')
<link rel="stylesheet" href="/css/library/library_store.css" type="text/css">
@section('grade_9')

    <div class="row">
        <div class="image">
            <img src="/image/demo.jpg" alt="demo">
        </div>
    </div>
    <div class="row">
        <?php use Illuminate\Support\Facades\DB;
        $data =DB::table('libraries')
            ->where('subject_name','=','Toán')
            ->where('grade','=','9')
            ->limit(3)
            ->get();?>
        @if(isset($data))
            <div class="title">
                <p><?php print($data[0]->subject_name) ?></p>
                <a href="{{route('views_grade_all',[$data[0]->subject_name, $data[0]->grade])}}">Xem tất cả</a>
            </div>
            <div class="contents">
                @foreach($data as $item)
                    <div class="item">
                        <p class="titles">{{$item->title}}</p>
                        <p><i class="fas fa-folder-open"></i> {{$item->subject_name}} {{$item->grade}}</p>
                        <p>Tác giả: {{$item->author}}</p>
                        <a href="{{route('views',$item->slug)}}">Đọc online</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="row">
        <?php
        $data =DB::table('libraries')
            ->where('subject_name','=','Vật Lý')
            ->where('grade','=','9')
            ->limit(3)
            ->get();?>
        @if(!empty($data))
            <div class="title">
                <p><?php print($data[0]->subject_name) ?></p>
                <a href="{{route('views_grade_all',[$data[0]->subject_name, $data[0]->grade])}}">Xem tất cả</a>
            </div>
            <div class="contents">
                @foreach($data as $item)
                    <div class="item">
                        <p class="titles">{{$item->title}}</p>
                        <p><i class="fas fa-folder-open"></i> {{$item->subject_name}} {{$item->grade}}</p>
                        <p>Tác giả: {{$item->author}}</p>
                        <a href="{{route('views',$item->slug)}}">Đọc online</a>
                    </div>
                @endforeach
            </div>
            @elseif(empty($data))
                <div class="title">
                    <p>Vật Lý</p>
                    <a href="">Xem tất cả</a>
                </div>
        @endif
    </div>
    <div class="row">
        <?php
        $data =DB::table('libraries')
            ->where('subject_name','=','Hóa Học')
            ->where('grade','=','9')
            ->limit(3)
            ->get();?>
        @if(!empty($data))
            <div class="title">
                <p><?php print($data[0]->subject_name) ?></p>
                <a href="{{route('views_grade_all',[$data[0]->subject_name, $data[0]->grade])}}">Xem tất cả</a>
            </div>
            <div class="contents">
                @foreach($data as $item)
                    <div class="item">
                        <p class="titles">{{$item->title}}</p>
                        <p><i class="fas fa-folder-open"></i> {{$item->subject_name}} {{$item->grade}}</p>
                        <p>Tác giả: {{$item->author}}</p>
                        <a href="{{route('views',$item->slug)}}">Đọc online</a>
                    </div>
                @endforeach
            </div>
        @elseif(empty($data))
            <div class="title">
                <p> Hóa Học</p>
                <a href="">Xem tất cả</a>
            </div>
        @endif
    </div>
    <div class="row">
        <?php
        $data =DB::table('libraries')
            ->where('subject_name','=','Tiếng Anh')
            ->where('grade','=','9')
            ->limit(3)
            ->get();?>
        @if(!empty($data))
            <div class="title">
                <p><?php print($data[0]->subject_name) ?></p>
                <a href="{{route('views_grade_all',[$data[0]->subject_name, $data[0]->grade])}}">Xem tất cả</a>
            </div>
            <div class="contents">
                @foreach($data as $item)
                    <div class="item">
                        <p class="titles">{{$item->title}}</p>
                        <p><i class="fas fa-folder-open"></i> {{$item->subject_name}} {{$item->grade}}</p>
                        <p>Tác giả: {{$item->author}}</p>
                        <a href="{{route('views',$item->slug)}}">Đọc online</a>
                    </div>
                @endforeach
            </div>
        @elseif(empty($data))
            <div class="title">
                <p>Tiếng anh</p>
                <a href="">Xem tất cả</a>
            </div>
        @endif
    </div>
    <div class="row">
        <?php
        $data =DB::table('libraries')
            ->where('subject_name','=','Văn')
            ->where('grade','=','9')
            ->limit(3)
            ->get();?>
        @if(!empty($data))
            <div class="title">
                <p><?php print($data[0]->subject_name) ?></p>
                <a href="{{route('views_grade_all',[$data[0]->subject_name, $data[0]->grade])}}">Xem tất cả</a>
            </div>
            <div class="contents">
                @foreach($data as $item)
                    <div class="item">
                        <p class="titles">{{$item->title}}</p>
                        <p><i class="fas fa-folder-open"></i> {{$item->subject_name}} {{$item->grade}}</p>
                        <p>Tác giả: {{$item->author}}</p>
                        <a href="{{route('views',$item->slug)}}">Đọc online</a>
                    </div>
                @endforeach
            </div>
        @elseif(empty($data))
            <div class="title">
                <p>Văn</p>
                <a href="">Xem tất cả</a>
            </div>
        @endif
    </div>
@endsection

