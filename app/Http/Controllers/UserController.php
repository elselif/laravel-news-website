<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function UserDashboard(){
        $id= Auth::user()->id;
        $userData= User::find($id);
        return view('frontend.user_dashboard', compact('userData'));
    }
    public function UserProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->surname = $request->surname;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;

        if($request->file('photo')){

            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);
            $data['photo'] = $filename;

        }

        $data->save();

        

        return back()->with("status", "Profile Updated Successfully");

    } 

    public function UserLogout(Request $request)
    {
      Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

       

        return redirect('/login')->with('status', 'You are logged out');
    } //end method

    public function ChangePassword()
    {
        $id = Auth::user()->id;
        $userData = User::find($id);
        return view('frontend.change_password',compact('userData'));
    }

    public function UserChangePassword(Request $request){
        //Validation

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        //Match The Old Password

        if(!Hash::check($request->old_password, auth::user()->password)){
            return back()->with('error',"Old Password Doesn't Match!");
        }

        // Update The New Password 

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('status',"Password Changed Successfully");

    }

        
}


