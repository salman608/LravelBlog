<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subscriber;

class SubscriberController extends Controller
{
    public function index(){
        $subscribers=Subscriber::latest()->get();
      return view('admin.subscriber.index',compact('subscribers'));
    }

    public function destroy($subscriber){
       $subscriber=Subscriber::findOrFail($subscriber)->delete();
       Toastr::success('Subscriber Successfully delete :)' ,'Success');
       return redirect()->back();
    }
}
