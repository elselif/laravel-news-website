<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.index'); 
    }

    public function AdminLogout(Request $request)
    {
      Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

       


        return redirect('/admin/logout/page');
    } //end method

    public function AdminLogin()
    {
        return view('admin.admin_login');
    } //end method

    public function AdminLogoutPage()
    {
        return view('admin.admin_logout');
    } //end method

    public function AdminProfile()
    {
        $id= Auth::user()->id;
        $adminData= User::find($id);
        return view('admin.admin_profile_view', compact('adminData'));
    } //end method

    public function AdminProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;

        if($request->file('photo')){

            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['photo'] = $filename;

        }

        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } //end method

    public function AdminChangePassword(){
        return view('admin.admin_change_password');
    }

    public function AdminUpdatePassword(Request $request){
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

    public function AllAdmin(){
        $alladminuser = User::where('role','admin')->latest()->get();
        return view('backend.admin.all_admin', compact('alladminuser'));
    }

    public function AddAdmin(){
        return view('backend.admin.add_admin');
    }

    public function StoreAdmin(Request $request){
        $user = new User();
        $user->surname = request('surname');
        $user->name = request('name');
        $user->email = request('email');
        $user->phone = request('phone');
        $user->password = Hash::make(request('password'));
        $user->role = 'admin';
        $user->status = 'inactive';
        $user->save();

        $notification = array(
            'message' => 'Admin User Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.admin')->with($notification);
    }

    public function EditAdmin($id){
        $adminuser = User::findorFail($id);
        return view('backend.admin.edit_admin', compact('adminuser'));
    }

    public function UpdateAdmin(Request $request){

        $admin_id = $request -> id;

        $user = User::findorFail($admin_id);
        $user->surname = request('surname');
        $user->name = request('name');
        $user->email = request('email');
        $user->phone = request('phone');
        $user->role='admin';
        $user->status = 'inactive';
        $user->save();

        $notification = array(
            'message' => 'Admin User Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.admin')->with($notification);
    }

    public function DeleteAdmin($id){
        $adminuser = User::findorFail($id);
        $adminuser->delete();

        $notification = array(
            'message' => 'Admin User Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.admin')->with($notification);
    }

    public function InactiveAdminUser($id)
    {
        User::findOrFail($id)->update(['status' => 'inactive']);

        $notification = array(
            'message' => 'Admin User Inactive Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } 

    public function ActiveAdminUser($id)
    {
        User::findOrFail($id)->update(['status' => 'active']);

        $notification = array(
            'message' => 'Admin User Active Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }



}
