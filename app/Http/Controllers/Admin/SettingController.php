<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;



class SettingController extends Controller
{
    public function index(){
      return view('admin.setting');
    }

    public function updateProfile(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email',
            'image'=>'required|image'
        ]);

        $image=$request->file('image');
        $slug=str_slug($request->name);
        $user=User::findOrFail(Auth::id());
       if(isset($image))
       {
         $currentData= Carbon::now()->toDateString();
         $imageName=$slug .'-'. $currentData .'-'. uniqid() .'.'.
         $image->getClientOriginalExtension();
                 if(!file_exists('uploads/adminprofile')){
              mkdir('uploads/adminprofile',0777,true);
          }
          $image->move('uploads/adminprofile',$imageName);
        }else{
          $imageName=$user->image;
          }
         $user->name=$request->name;
         $user->email=$request->email;
         $user->about=$request->about;
         $user->image=$imageName;
         $user->save();
         Toastr::success('Profile successfully update','success');
         return redirect()->back();
    }

    public function updatePassword(Request $request){
        $this->validate($request,[
            'old_password'=>'required',
            'password' =>'required|Confirmed'
        ]);

        $hashedPassword=Auth::user()->password;
        if(Hash::check($request->old_password,$hashedPassword)){
            if(!Hash::check($request->password,$hashedPassword)){
                $user=User::find(Auth::id());
                $user->password=Hash::make($request->password);
                $user->save();
                Toastr::success('Password successfully update','success');
                Auth::logout();
                return redirect()->back();
            }else{
                Toastr::error('NewPassword can not be Same','error');
                return redirect()->back();
            }
        }else{
            Toastr::error('Current Password not match','error');
            return redirect()->back();
        }

    }
}
