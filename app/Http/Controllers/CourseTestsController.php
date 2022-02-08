<?php

namespace App\Http\Controllers;

use App\Models\CourseTests;
use App\Models\QuestionBank;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseTestsController extends Controller
{
    public function list_question($course_id){
        $list_question = DB::table('course_tests')
            ->where('course_id', '=', $course_id)
            ->orderBy('question_id')
            ->get()->all();
        return view('course.tests.list_question',compact('list_question','course_id'));
    }
    public function create_question($course_id){
        if (Auth::user()->role== "lecture"){
            return view('course.tests.create_question',compact('course_id'));
        }
        else{
            return redirect()->with('error','error')->route('login');
        }
    }
    public function views_question_detail($course_id, $id){
        if (Auth::user()->role== "lecture"){
            $result = DB::table('course_tests')->where( 'course_id','=',$course_id)
                ->where('id','=',$id)
                ->get()->first();
            return view('course.tests.views_question_detail',compact('result'));
        }
        else{
            return redirect()->with('error','error')->route('login');
        }
    }
    public function update_question($course_id, $id){
        if (Auth::user()->role== "lecture"){
            $result = DB::table('course_tests')->where( 'course_id','=',$course_id)
            ->where('id','=',$id)
                ->get()->first();
            return view('course.tests.update_question',compact('result'));
        }
        else{
            return redirect()->with('error','error')->route('login');
        }
    }
    public function check_validate_create_question(Request $request){
        $request->validate([
            'question_id'=>'required|numeric',
            'question'=>'required|string',
            'choose_1'=>'required',
            'choose_2'=>'required',
            'choose_3'=>'required',
            'choose_4'=>'required',
            'answer'=>'required|string',
            'point'=>'required|numeric'
        ]);
    }
    public function check_exit_question_bank(Request $request){
        $result = DB::table('question_banks')
            ->where('question','=', $request->question)
            ->get(['choose_1','choose_2','choose_3','choose_4'])->first();
        if($result != null){
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
        else{
            return true;
        }

    }
    public function post_create_question(Request $request, $course_id)
    {
        $this->check_validate_create_question($request);
        if(CourseTests::where('course_id',$course_id)
            ->where('question_id',$request->question_id)
            ->exists()){
            return redirect()->back()->with('error','Tải lên thất bại, câu hỏi số '.$request->question_id.' đã tồn tại!');
        }
        if(CourseTests::where('course_id',$course_id)
            ->where('question',$request->question)
            ->exists()){
            return redirect()->back()->with('error','Tải lên thất bại, câu hỏi đã tồn tại!');
        }
        $username = Auth::user()->username;
        CourseTests::create([
            'username'=>$username,
            'course_id'=>$course_id,
            'question_id'=>$request->question_id,
            'question'=>$request->question,
            'choose_1'=>$request->choose_1,
            'choose_2'=>$request->choose_2,
            'choose_3'=>$request->choose_3,
            'choose_4'=>$request->choose_4,
            'answer'=>$request->answer,
            'point'=>$request->point
        ]);

        if($this->check_exit_question_bank($request) == true){
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
    public function check_validate_update_question(Request $request){
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
    public function post_update_question(Request $request, $course_id, $id){
        $this->check_validate_update_question($request);
        $username = Auth::user()->username;
        $user_check = DB::table('course_tests')
            ->where('course_id','=',$course_id)
            ->where('id','=',$id)
            ->get('username')->first();
        if($username == $user_check->username){
            DB::table('course_tests')
                ->where('course_id','=',$course_id)
                ->where('id','=',$id)
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
    public function check_answer(Request $request, $course_id){
        $count = DB::table('course_tests')
            ->select('*')
            ->selectRaw('COUNT(id) as number')
            ->where('course_id','=',$course_id)
            ->groupBy('course_id','username')
            ->get();
        $result = DB::table('course_tests')
            ->where('course_id','=',$course_id)
            ->get(['id','answer','point'])->all();
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
        $final_score = ($total_point/$max_point) * 10;
        $check_course_exits = DB::table('course_achievements')
            ->where('username',auth()->user()->username)
            ->where('course_id',$course_id)
            ->exists();
        if ($check_course_exits == true)
        {
            $midterm_score = DB::table('course_achievements')
                ->where('username',auth()->user()->username)
                ->where('course_id',$course_id)
                ->get('midterm_score')->first();
            $mark = ($midterm_score->midterm_score * 30 / 100) + ($final_score * 70 / 100);
            if($mark >= 5.0){
                DB::table('course_achievements')
                    ->where('username','=',auth()->user()->username)
                    ->where('course_id','=',$course_id)
                    ->update([
                        'final_score'=>$final_score,
                        'mark'=>$mark,
                        'achievement'=>'pass',
                    ]);
            }
            else{
                DB::table('course_achievements')
                    ->where('username','=',auth()->user()->username)
                    ->where('course_id','=',$course_id)
                    ->update([
                        'final_score'=>$final_score,
                        'mark'=>$mark,
                        'achievement'=>'fail',
                    ]);
            }
        }
        $slug = DB::table('courses')
            ->where('course_id','=',$course_id)
            ->get('slug')->first();
        return view('course.show_test_result',compact('total_point','course_id','max_point','slug'));
    }
}
