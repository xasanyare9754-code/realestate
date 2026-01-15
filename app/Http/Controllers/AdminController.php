<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.index');
    
} //end method
    public function AdminLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    } //end method

    public function AdminLogin()
    {
        return view('admin.admin_login');
    } //end method
    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
       return view('admin.admin_profile_view', compact('profileData'));
    } //end method  

    public function AdminLoginSubmit(Request $request) {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $login = $request->login;
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : (is_numeric($login) ? 'phone' : 'name');
        
        if (Auth::attempt([$field => $login, 'password' => $request->password])) {
             $request->session()->regenerate();
             return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ]);
    } 
}
