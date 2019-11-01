<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Session;
use App\Category;
use App\Tag;

class PostController extends Controller
{

    public function index(){
      return $posts=Post::latest()->approved()->published->paginate(6);
        return view('frontend.category',compact('posts'));
    }
    public function details($slug){
      $post=Post::where('slug',$slug)->first();
      $blogkey='blog'.$post->id;
      if (!Session::has($blogkey)) {
          $post->increment('view_count');
          Session::put($blogkey,1);
      }
      $randomposts=Post::all()->random(3);
      return view('frontend.posts',compact('post','randomposts'));
    }

     public function categoryPost($slug){
       $category = Category::where('slug',$slug)->first();
       $posts = $category->posts()->approved()->published()->get();
       return view('frontend.categoryposts',compact('category','posts'));
     }

     public function tagPost($slug){
       $tag = Tag::where('slug',$slug)->first();
       $posts = $tag->posts()->approved()->published()->get();
       return view('frontend.tags',compact('tag','posts'));
     }
}
