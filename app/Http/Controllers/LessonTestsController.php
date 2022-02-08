<?php

namespace App\Http\Controllers;

use App\Models\CourseAchievements;
use App\Models\LessonAchievements;
use App\Models\LessonTests;
use App\Models\QuestionBank;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LessonTestsController extends Controller
{
    public function lesson_list_question($course_id, $lesson_id){
        $list_question = DB::table('lesson_tests')
            ->where('course_id', '=', $course_id)
            ->where('lesson_id', '=',$lesson_id)
            ->orderBy('question_id')->get()->all();
        return view('lesson.tests.list_question',compact('list_question',['course_id','lesson_id']));
    }
    public function lesson_create_question($course_id, $lesson_id){
        if (Auth::user()->role== "lecture"){
            return view('lesson.tests.create_question',compact('course_id','lesson_id'));
        }
        else{
            return redirect()->with('error','error')->route('login');
        }
    }
    public function views_question_detail($course_id,$lesson_id, $question_id){
        if (Auth::user()->role== "lecture"){
            $result = DB::table('lesson_tests')->where( 'course_id','=',$course_id)
                ->where('lesson_id','=',$lesson_id)
                ->where('question_id','=',$question_id)
                ->get()->first();
            return view('lesson.tests.views_question_detail',compact('result'));
        }
        else{
            return redirect()->with('error','error')->route('login');
        }
    }
    public function update_question($course_id,$lesson_id, $question_id){
        if (Auth::user()->role== "lecture"){
            $result = DB::table('lesson_tests')
                ->where( 'course_id','=',$course_id)
                ->where('lesson_id','=',$lesson_id)
                ->where('question_id','=',$question_id)
                ->get()->first();
            return view('lesson.tests.update_question',compact('result'));
        }
        else{
            return redirect()->with('error','error')->route('login');
        }
    }
    public function check_validate_question(Request $request){
        $request->validate([
            'question'=>'required|string',
            'choose_1'=>'required',
            'choose_2'=>'required',
            'choose_3'=>'required',
            'choose_4'=>'required',
            'answer'=>'required|string',
            'point'=>'required|numeric'
        ]);
    }
    public function check_exits_question_bank(Request $request){
        $result = DB::table('question_banks')
            ->where('question',$request->question)
            ->get(['choose_1','choose_2','choose_3','choose_4'])->first();
        if(isset($result)){
            $arr1 = [$result->choose_1, $result->choose_2, $result->choose_3 , $result->choose_4];
            $arr2 = [$request->choose_1, $request->choose_2, $request->choose_3 , $request->choose_4];
            $check = array_intersect($arr1, $arr2);
            $number = sizeof($check);
            if($number == 4){
                return false;
            }
            else{
                return true;
            }
        }
        return true;
    }
    public function post_create_question(Request $request, $course_id, $lesson_id)
    {
        $this->check_validate_question($request);
        if(LessonTests::where('course_id',$course_id)
            ->where('lesson_id',$lesson_id)
            ->where('question_id',$request->question_id)
            ->exists()){
            return redirect()->back()->with('error','Tải lên thất bại, id câu hỏi đã tồn tại!');
        }
        $username = Auth::user()->username;
        LessonTests::create([
            'username'=>$username,
            'course_id'=>$course_id,
            'lesson_id'=>$lesson_id,
            'question_id'=>$request->question_id,
            'question'=>$request->question,
            'choose_1'=>$request->choose_1,
            'choose_2'=>$request->choose_2,
            'choose_3'=>$request->choose_3,
            'choose_4'=>$request->choose_4,
            'answer'=>$request->answer,
            'point'=>$request->point
        ]);
        if($this->check_exits_question_bank($request) == true){
            $result = DB::table('courses')
                ->where('course_id','=',$course_id)
                ->get('subject_name')->first();
            QuestionBank::create([
                'course_id'=>$course_id,
                'subject_name'=>$result->subject_name,
                'question'=>$request->question,
                'choose_1'=>$request->choose_1,
                'choose_2'=>$request->choose_2,
                'choose_3'=>$request->choose_3,
                'choose_4'=>$request->choose_4,
                'answer'=>$request->answer,
                'point'=>$request->point
            ]);
        }
        return redirect()->back()->with('success','Tải lên thành công!');
    }
    public function post_update_question(Request $request, $course_id, $lesson_id, $question_id){
        $this->check_validate_question($request);
        $username = Auth::user()->username;
        $user_check = DB::table('course_tests')
            ->where('course_id','=',$course_id)
            ->where('question_id','=',$question_id)
            ->get('username')->first();
        if($username == $user_check->username){
            DB::table('lesson_tests')
                ->where('course_id','=',$course_id)
                ->where('lesson_id','=',$lesson_id)
                ->where('question_id','=',$question_id)
                ->update([
                    'question'=>$request->question,
                    'choose_1'=>$request->choose_1,
                    'choose_2'=>$request->choose_2,
                    'choose_3'=>$request->choose_3,
                    'choose_4'=>$request->choose_4,
                    'answer'=>$request->answer,
                    'point'=>$request->point
                ]);
            return redirect()->back()->with('success','Cập nhật thành công!');
        }
        else{
            return redirect()->back()->with('error','Bạn không thể thay đổi nội dung này, Vui lòng kiểm tra lại!');
        }
    }
    public function check_answer(Request $request, $course_id, $lesson_id){
        $count = DB::table('lesson_tests')
            ->select('*')
            ->selectRaw('COUNT(question_id) as number')
            ->where('course_id','=',$course_id)
            ->where('lesson_id','=',$lesson_id)
            ->groupBy('course_id','username','lesson_id')
            ->get();
        $result = DB::table('lesson_tests')
            ->where('course_id','=',$course_id)
            ->where('lesson_id','=',$lesson_id)
            ->get(['question_id','answer','point'])->all();
        $total_point = 0;
        $max_point = 0;
        for($i = 0 ; $i < $count[0]->number;){
            $choose = "choose".($i+1);
            if(isset($request->$choose)){
                if($result[$i]->answer == $request->$choose){
                    $total_point += $result[$i]->point;
                    $max_point +=$result[$i]->point;
                }
                else{
                    $total_point += 0;
                    $max_point +=$result[$i]->point;
                }
            }
            else{
                $total_point += 0;
                $max_point +=$result[$i]->point;
            }
            $i += 1;
        }
        $course_name = DB::table('courses')
            ->where('course_id','=',$course_id)
            ->get(['course_name'])->first();
        $check_exits = DB::table('lesson_achievements')
            ->where('username',auth()->user()->username)
            ->where('course_id',$course_id)
            ->where('lesson_id',$lesson_id)
            ->exists();
        if($check_exits == false) {
            $mark = ($total_point/$max_point) * 10;
            LessonAchievements::create([
                'username'=>auth()->user()->username,
                'course_id'=>$course_id,
                'course_name'=>$course_name->course_name,
                'lesson_id'=>$lesson_id,
                'mark'=>$mark
            ]);
            $getMark = DB::table('lesson_achievements')
                ->where('course_id','=',$course_id)
                ->where('username','=',auth()->user()->username)
                ->get('mark')->all();
            $i = 0;
            $score = 0 ;
            foreach ($getMark as $item){
                $i += 1;
                $score += $item->mark;
            }
            $midterm_score = $score / $i;

            $check_course_exits = DB::table('course_achievements')
                ->where('username',auth()->user()->username)
                ->where('course_id',$course_id)
                ->exists();
            if($check_course_exits == false){
                CourseAchievements::create([
                    'username'=>auth()->user()->username,
                    'course_id'=>$course_id,
                    'course_name'=>$course_name->course_name,
                    'midterm_score'=>$midterm_score,
                ]);
            }
            else{
                DB::table('course_achievements')
                    ->where('username','=',auth()->user()->username)
                    ->where('course_id','=',$course_id)
                    ->update([
                       'midterm_score'=>$midterm_score,
                    ]);
            }
        }
        $slug = DB::table('courses')
            ->where('course_id','=',$course_id)
            ->get('slug')->first();
        return view('lesson.show_lesson_test_result',compact('total_point','course_id','lesson_id','max_point','slug'));
    }
}
