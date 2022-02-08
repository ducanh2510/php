<?php

namespace App\Http\Controllers;

use App\Models\CourseTests;
use App\Models\LessonTests;
use App\Models\QuestionBank;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class QuestionBankController extends Controller
{
    public function show(){
        if(auth()->user()->role == "lecture"){
            $list_question =  DB::table('question_banks')->paginate(20);
            Paginator::useBootstrap();
            return view('course.question_bank', compact('list_question'));
        }
        else{
            return redirect();
        }
    }
    public function insert_to_course($course_id){
        if(auth()->user()->role == "lecture"){
            $list_question =  DB::table('question_banks')->paginate(20);
            Paginator::useBootstrap();
            return view('course.question_bank', compact('list_question','course_id'));
        }
        else{
            return redirect();
        }
    }
    public function insert_to_lesson($course_id, $lesson_id){
        if(auth()->user()->role == "lecture"){
            $list_question =  DB::table('question_banks')->paginate(20);
            Paginator::useBootstrap();
            return view('course.question_bank', compact('list_question','course_id','lesson_id'));
        }
        else{
            return redirect();
        }
    }
    public function views_detail($id){
        $result = QuestionBank::find($id);
        return view('course.question_bank_views_detail',compact('result'));
    }
    public function insert_question($id){
        return view('course.insert_question',compact('id'));
    }
    public function check_exits_question(Request $request, $data){
        $result = DB::table('course_tests')
            ->where('course_id','=',$request->course_id)
            ->where('question',$data->question)
            ->get(['choose_1','choose_2','choose_3','choose_4'])->first();
        if($result != null){
            $arr1 = [$result->choose_1, $result->choose_2, $result->choose_3 , $result->choose_4];
            $arr2 = [$data->choose_1, $data->choose_2, $data->choose_3 , $data->choose_4];
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
    public function post_insert_question(Request $request, $course_id, $id){
    //check lai cho nay
    $data = DB::table('course_tests')->where('course_id','=',$course_id)->get()->all();
    $next_id = count($data)+1;

    $new_data= DB::table('question_banks')->where('id','=',$id)
        ->get()->first();
    if ($this->check_exits_question($request, $new_data) == true){
        CourseTests::create([
            'username'=>auth()->user()->username,
            'course_id'=>$course_id,
            'question_id'=>$next_id,
            'question'=>$new_data->question,
            'choose_1'=>$new_data->choose_1,
            'choose_2'=>$new_data->choose_2,
            'choose_3'=>$new_data->choose_3,
            'choose_4'=>$new_data->choose_4,
            'answer'=>$new_data->answer,
            'point'=>$new_data->point
        ]);
        return redirect()->back()->with('success','Thêm thành công!.');
    }
    else{
        return redirect()->back()->with('error','Câu hỏi đã tồn tại trong bài kiểm tra!');
    }

    }
    public function check_exits_lesson_question(Request $request, $data){
        $result = DB::table('lesson_tests')
            ->where('course_id','=',$request->course_id)
            ->where('lesson_id','=',$request->lesson_id)
            ->where('question','=',$data->question)
            ->get(['choose_1','choose_2','choose_3','choose_4'])->first();
        if($result != null){
            $arr1 = [$result->choose_1, $result->choose_2, $result->choose_3 , $result->choose_4];
            $arr2 = [$data->choose_1, $data->choose_2, $data->choose_3 , $data->choose_4];
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
    public function post_insert_lesson_question(Request $request, $course_id, $lesson_id, $id){

        $check_course = DB::table('lessons')
            ->where('course_id',$course_id)
            ->where('lesson_id',$lesson_id)
            ->exists();
        if($check_course == false){
            return redirect()->back()->with('error','Bài học không tồn tại, vui lòng thử lại');
        }
        else{
            $check_user = DB::table('lesson_tests')
                ->where('course_id','=',$course_id)
                ->where('lesson_id','=',$lesson_id)
                ->get('username')->first();
            $data = DB::table('lesson_tests')
                ->where('course_id','=',$course_id)
                ->where('lesson_id','=',$lesson_id)
                ->get()->all();
            if(count($data) == 0){
                $next_id = count($data)+1;
                $new_data= DB::table('question_banks')->where('id','=',$id)
                    ->get()->first();
                if ($this->check_exits_lesson_question($request, $new_data) == true){
                    LessonTests::create([
                        'username'=>auth()->user()->username,
                        'course_id'=>$course_id,
                        'lesson_id'=>$lesson_id,
                        'question_id'=>$next_id,
                        'question'=>$new_data->question,
                        'choose_1'=>$new_data->choose_1,
                        'choose_2'=>$new_data->choose_2,
                        'choose_3'=>$new_data->choose_3,
                        'choose_4'=>$new_data->choose_4,
                        'answer'=>$new_data->answer,
                        'point'=>$new_data->point
                    ]);
                    return redirect()->back()->with('success','Thêm thành công!.');
                }
                else{
                    return redirect()->back()->with('error','Câu hỏi đã tồn tại trong bài kiểm tra!');
                }
            }
            else{
                $next_id = count($data)+1;
                if(auth()->user()->username == $check_user->username){
                    $new_data= DB::table('question_banks')->where('id','=',$id)
                        ->get()->first();
                    if ($this->check_exits_lesson_question($request, $new_data) == true){
                        LessonTests::create([
                            'username'=>auth()->user()->username,
                            'course_id'=>$course_id,
                            'lesson_id'=>$lesson_id,
                            'question_id'=>$next_id,
                            'question'=>$new_data->question,
                            'choose_1'=>$new_data->choose_1,
                            'choose_2'=>$new_data->choose_2,
                            'choose_3'=>$new_data->choose_3,
                            'choose_4'=>$new_data->choose_4,
                            'answer'=>$new_data->answer,
                            'point'=>$new_data->point
                        ]);
                        return redirect()->back()->with('success','Thêm thành công!.');
                    }
                    else{
                        return redirect()->back()->with('error','Câu hỏi đã tồn tại trong bài kiểm tra!');
                    }
                }
                else{
                    return redirect()->back()->with('error','Bạn không sở hữu khóa học này!');
                }
            }
        }
    }
    public function search(Request $request){
//        $questions = DB::table('question_bank')->where('subject_name','LIKE', '%'.$request->input('keyword').'%')->get()->all();
//        $output = '';
//        foreach ($questions as $question){
//            $output = '<tr>
//                <td>'.$question->course_id.'</td>
//                <td>'.$question->course_id.'</td>
//                <td>'.$question->course_id.'</td>
//
//            </tr>';
//        }
//        dd($output);
//        return response()->json($output);
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = DB::table('question_banks')
                ->where('subject_name', 'LIKE', "%{$query}%")
                ->get();
            $output = '';
            foreach($data as $row)
            {
                $output .= '<tr>
                <td class="text-center">'.$row->course_id.'</td>
                <td class="text-center">'.$row->subject_name.'</td>
                <td class="text-center">'.$row->question.'</td>
                <td class="text-center"><a href="'.route('question_bank_views_detail',$row->id).'"><i class="fas fa-eye"></i></a></td>
            </tr>';
            }
           // $output .= '</ul>';
            echo $output;
        }
    }
}
