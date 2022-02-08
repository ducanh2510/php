<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    public function lesson_views($slug){
        if(Auth::check()){
            $view = Lesson::find($slug);
            $course = DB::table('courses')
                ->where('course_id','=',$view->course_id)
                ->get()->first();
            $lessons = DB::table('lessons')
                ->where('lessons.course_id','=',$view->course_id)
                ->get()->sortBy('lesson_name')->all();
            $list_comment = DB::table('comments')
                ->where('course_id', '=', $view->course_id ?? 0)->get();
            return view('lesson.lesson',compact('view','course','lessons','list_comment'));
        }
        else {
            return redirect()->back()->with('error','error');
        }
    }
    public function list_lesson(){
        if (Auth::user()->role== "lecture"){
            $current_email = auth()->user()->email;
            $lecture_name = DB::table('lectures')->where('email','=',$current_email)->get()->first();
            $name = $lecture_name->first_name." ".$lecture_name->last_name;
            $list_lesson = DB::table('lessons')
                ->select('lessons.*', 'courses.course_name')
                ->join('courses', 'courses.course_id', '=', 'lessons.course_id')
                ->paginate(8);
            Paginator::useBootstrap();
            return view('lesson.list_lesson',['list_lesson'=>$list_lesson,'lecture_name'=>$name]);
        }
        else{
            return redirect()->with('error','error')->route('login');
        }
    }
    public function lesson_views_detail($slug){
        $lesson = Lesson::find($slug);
        return view('lesson.lesson_views_detail',compact('lesson'));
    }
    public function upload_lesson($course_id, $subject_name){
        if (Auth::user()->role== "lecture"){
            return view('lesson.upload_lesson',compact('course_id','subject_name'));
        }
        else{
            return redirect()->with('error','error')->route('login');
        }
    }
    public function check_upload_lesson(Request $request){
        $request->validate([
            'lesson_id'=>'required|numeric',
            'lesson_name'=>'required|string',
            'slug'=>'required'
        ]);
    }
    public function post_upload_lesson(Request $request, $course_id, $subject_name){
        $this->check_upload_lesson($request);
        $video_name = $request->video->getClientOriginalName();
        $request->video->move('lesson',$video_name);
        $check = DB::table('courses')
            ->where('course_id','=',$course_id)
            ->get()->first();
        if(isset($check)){
            $check_lesson_id = DB::table('lessons')
                ->where('lesson_id',$request->lesson_id)
                ->exists();
            if($check_lesson_id == true){
                return redirect()->back()->with('error','bài học '.$request->lesson_id.' đã tồn tại, bạn muốn cập nhật?');
            }
            Lesson::create([
                'course_id'=>$course_id,
                'subject_name'=>$subject_name,
                'lesson_id'=>$request->lesson_id,
                'lesson_name'=>$request->lesson_name,
                'video'=>$video_name,
                'slug'=>$request->slug,
            ]);
            return redirect()->back()->with('success','Tải lên thành công!');
        }
        else{
            return redirect()->back()->with('error','Mã khóa học không tồn tại. Vui lòng nhập lại!');
        }

    }
    public function update_lesson($slug){
        if (Auth::user()->role== "lecture"){
            $lesson = Lesson::find($slug);
            return view('lesson.update_lesson',compact('lesson'));
        }
        else{
            return redirect()->with('error','error')->route('login');
        }
    }
    public function check_update_lesson(Request $request){
        $request->validate([
            'lesson_name'=>'required|string',
            'slug'=>'required'
        ]);
        if($request->update_video == null){
            $request->validate([
                'current_video'=>'required',
            ]);
        }
        else{
            $request->validate([
               'update_video'=>'required',
            ]);
        }
    }
    public function post_update_lesson(Request $request, $course_id, $lesson_id, $subject_name){
        $this->check_update_lesson($request);
        if($request->update_video == null){
            DB::table('lessons')
                ->where('subject_name','=',$subject_name)
                ->where('course_id','=',$course_id)
                ->where('lesson_id','=',$lesson_id)
                ->update([
                    'lesson_name'=>$request->lesson_name,
                    'slug'=>$request->slug,
                ]);
            return redirect()->back()->with('success','Cập nhật thành công!');
        }
        else{
            if($request->current_video != $request->upload_video){
                $file_path = public_path()."/lesson/".$request->current_video;
                if($file_path != null){
                    unlink($file_path);
                }
            }
            $video_name = $request->update_video->getClientOriginalName();
            $request->update_video->move('lesson',$video_name);

            DB::table('lessons')
                ->where('subject_name','=',$subject_name)
                ->where('course_id','=',$course_id)
                ->where('lesson_id','=',$lesson_id)
                ->update([
                    'lesson_name'=>$request->lesson_name,
                    'video'=>$video_name,
                    'slug'=>$request->slug,
                ]);
            return redirect()->back()->with('success','Cập nhật thành công!');
        }
    }
    public function lesson_test($course_id, $lesson_id){
        $count = DB::table('lesson_tests')
            ->select('*')
            ->selectRaw('COUNT(question_id) as number')
            ->where('course_id','=',$course_id)
            ->where('lesson_id','=',$lesson_id)
            ->groupBy('course_id','username','lesson_id')
            ->get()->all();
        $result = DB::table('lesson_tests')
            ->where('course_id','=',$course_id)
            ->where('lesson_id','=',$lesson_id)
            ->orderBy('question_id')
            ->paginate(10);
        Paginator::useBootstrap();
//        if($count == null || $result == null){
//            return view('lesson.show_lesson_test',compact('result','count'))->with('error','Hiện chưa có bài kiểm tra cho bài học này. Vui lòng quay lại sau !');
//        }
        return view('lesson.show_lesson_test',compact('result','count'));
    }
    public function search(Request $request){
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = DB::table('lessons')
                ->where('course_id', 'LIKE', "%{$query}%")
                ->get();
            $output = '';
            foreach($data as $row) {
                $output .= '<tr>
                <td class="text-center">' . $row->course_id . '</td>
                <td class="text-center">' . $row->lesson_id . '</td>
                <td class="text-center">' . $row->lesson_name . '</td>
                <td class="text-center"><a href="' . route('lesson_list_question', [$row->course_id, $row->lesson_id]) . '"><i class="fas fa-file-alt"></i></a></td>
                <td class="text-center"><a href="' . route('lesson_views_detail', $row->slug) . '"><i class="fas fa-eye"></i></a></td>
                <td class="text-center"><a href="' . route('update_lesson', $row->slug) . '"><i class="fas fa-pen-alt"></i></a></td>            </tr>';
            }
            echo $output;
        }
    }
}
