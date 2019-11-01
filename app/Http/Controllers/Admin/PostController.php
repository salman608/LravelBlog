<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Tag;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Auth;
use App\Subscriber;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewPostNotify;
use App\Notifications\AuthorPostnotify;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Post::latest()->get();
        return view('admin.post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        $tags=Tag::all();
        return view('admin.post.create',compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    $this->validate($request,[
        'title' => 'required',
        'image' => 'required',
        'body' => 'required',
        'categories' => 'required',
        'tags' => 'required',
        ]);

   $image=$request->file('image');
   $slug=str_slug($request->title);
   if(isset($image))
   {
     $currentData= Carbon::now()->toDateString();
     $imagename=$slug .'-'. $currentData .'-'. uniqid() .'.'.
     $image->getClientOriginalExtension();
     if(!file_exists('uploads/post')){
         mkdir('uploads/post',0777,true);
     }
     $image->move('uploads/post',$imagename);
   }else{
     $imagename='default.png';
     }

      $post = new Post();
      $post->user_id=Auth::id();
      $post->title = $request->title;
      $post->slug = $slug;
      $post->image = $imagename;
      $post->body = $request->body;
      if (isset($request->status)) {
         $post->status=true;
      }else{
         $post->status=false;
      }

      $post->is_approved=true;
      $post->save();
      $post->categories()->attach($request->categories);
      $post->tags()->attach($request->tags);

      $subscribers=Subscriber::all();
      foreach ($subscribers as $key => $subscriber) {
        Notification::route('mail',$subscriber->email)
                    ->notify(new NewPostNotify($post));
      }
      Toastr::success('Post Successfully Saved :)' ,'Success');
      return redirect()->route('admin.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
      $categories=Category::all();
      $tags=Tag::all();
      return view('admin.post.edit',compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
      $this->validate($request,[
           'title' => 'required',
           'image' => 'image',
           'body' => 'required',
           'categories' => 'required',
           'tags' => 'required',
           ]);

      $image=$request->file('image');
      $slug=str_slug($request->title);
      if(isset($image))
      {
        $currentData= Carbon::now()->toDateString();
        $imagename=$slug .'-'. $currentData .'-'. uniqid() .'.'.
        $image->getClientOriginalExtension();
        if(!file_exists('uploads/post')){
           mkdir('uploads/post',0777,true);
        }
        $image->move('uploads/post',$imagename);
      }else{
        $imagename=$post->image;
        }


         $post->user_id=Auth::id();
         $post->title = $request->title;
         $post->slug = $slug;
         $post->image = $imagename;
         $post->body = $request->body;
         if (isset($request->status)) {
           $post->status=true;
         }else{
           $post->status=false;
         }

         $post->is_approved=true;
         $post->save();
         $post->categories()->sync($request->categories);
         $post->tags()->sync($request->tags);
         Toastr::success('Post Successfully Update :)' ,'Success');
         return redirect()->route('admin.post.index');
    }

    public function pending(){
      $posts=Post::where('is_approved',false)->get();
      return view('admin.post.pending',compact('posts'));
   }


     public function approval($id){
        $post=Post::find($id);
        if ($post->is_approved==false) {
           $post->is_approved=true;
           $post->save();
           $post->user->notify(new AuthorPostnotify($post));

           $subscribers=Subscriber::all();
           foreach ($subscribers as $key => $subscriber) {
             Notification::route('mail',$subscriber->email)
                         ->notify(new NewPostNotify($post));
           }

           Toastr::success('Post Successfully Approved :)' ,'Success');

       }else{
          Toastr::info('This Post is already  Approved :)' ,'info');
       }
       return redirect()->back();

     }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

    if(file_exists('uploads/post/'.$post->image))
    {
     unlink('uploads/post/'.$post->image);
    }
    $post->delete();
    Toastr::success('Post successfully Delete','success');
    return redirect()->back();

    }
}
