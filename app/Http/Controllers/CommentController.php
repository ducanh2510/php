<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function post_create_comment($id, Request $request){
        $username = Auth::user()->username;
        Comment::create([
            'username'=>$username,
            'course_id'=>$id,
            'commentString'=>$request->commentString
        ]);
        return redirect()->back()->with('success');
    }
}
