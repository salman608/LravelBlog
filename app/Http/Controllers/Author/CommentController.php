<?php

namespace App\Http\Controllers\Author;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;
use Brian2694\Toastr\Facades\Toastr;
use Auth;

class CommentController extends Controller
{
  public function index(){
      $posts=Auth::user()->posts;
      return view('author.comment',compact('posts'));
    }

    public function destroy($id){
        $comment=Comment::findOrFail($id);
        if ($comment->post->user->id==Auth::id()) {
          $comment->delete();
          Toastr::success('Comment Successfully Delete :)' ,'Success');
        }else{
          Toastr::error('you are not authorized in this post Delete :)' ,'error');
        }
        
        return redirect()->back();
    }
}
