<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
