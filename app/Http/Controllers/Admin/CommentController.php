<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;
use Brian2694\Toastr\Facades\Toastr;

class CommentController extends Controller
{
    public function index(){
      $comments=Comment::latest()->get();
      return view('admin.comment',compact('comments'));
    }

    public function destroy($id){
        $comments=Comment::findOrFail($id)->delete();
        Toastr::success('Comment Successfully Delete :)' ,'Success');
        return redirect()->back();
    }
}
