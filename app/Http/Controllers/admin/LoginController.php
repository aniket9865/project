<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    // This method will authenticate Admin
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.login')
                ->withInput()
                ->withErrors($validator);
        }

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {

            if (Auth::guard('admin')->user()->role != 'admin') {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('error', 'You are not authorized to access this page');
            }
            // Authentication passed
            return redirect()->route('admin.dashboard'); // Or wherever you want to redirect on successful login
        } else {
            return redirect()->route('admin.login')
                ->with('error', 'Email or Password is Incorrect');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
