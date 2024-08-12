<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    // Show login form
    public function index()
    {
        return view('login');
    }

    // This method will authenticate user
//    public function authenticate(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'email' => 'required|email',
//            'password' => 'required'
//        ]);
//
//        if ($validator->fails()) {
//            return redirect()->route('account.login')
//                ->withInput()
//                ->withErrors($validator);
//        }
//
//        if (Auth::attempt(['email' => $request->email, 'password' => $request->password,
//            ])) {
//            $user=User::where('email',$request->email)->get();
////            step1:if user exits form given email take password form input and compare it with password in database
////            step2:password is in hash format so make new password hash and compare two
////            dd($user);
//
//            // Authentication passed
////            if(Auth::User()->role != "customer") {
////                return redirect()->route('account.login')
////                    ->with('error', 'Please Login with user credentials');
////            }
//            return redirect()->route('account.dashboard');
//
//        } else {
//            return redirect()->route('account.login')
//                ->with('error', 'Email or Password is Incorrect');
//        }
//    }

    public function authenticate(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // If validation fails, redirect back with input and errors
        if ($validator->fails()) {
            return redirect()->route('account.login')
                ->withInput()
                ->withErrors($validator);
        }

        // Attempt to authenticate the user with the provided credentials
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Fetch the authenticated user
            $user = Auth::user();

            // Check if the user's role is 'customer'
            if ($user->role == 'customer') {
                // Authentication successful, and role is 'customer', redirect to the dashboard
                return redirect()->route('account.dashboard');
            } else {
                // Role is not 'customer', log out and redirect back with error
                Auth::logout();
                return redirect()->route('account.login')
                    ->with('error', 'You do not have the necessary permissions to access this area');
            }
        } else {
            // Authentication attempt failed, redirect back with error
            return redirect()->route('account.login')
                ->with('error', 'Email or Password is Incorrect');
        }
    }


    // Show registration form
    public function register()
    {
        return view('register');
    }

    // Process registration
    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.register')
                ->withInput()
                ->withErrors($validator);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'customer'; // Assuming 'customer' is a string, you may need to adjust according to your role management
        $user->save();

        return redirect()->route('account.login')->with('success', 'Registration Successful');
    }

    // Log out user
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login')->with('success', 'You have been logged out');
    }
}


//namespace App\Http\Controllers;
//
//use App\Models\User;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Validator;
//
//class LoginController extends Controller
//{
//    // Show login form
//    public function index()
//    {
//        return view('login');
//    }
//
//    // This method will authenticate user
//    public function authenticate(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'email' => 'required|email',
//            'password' => 'required'
//        ]);
//
//        if ($validator->fails()) {
//            return redirect()->route('account.login')
//                ->withInput()
//                ->withErrors($validator);
//        }
//
//        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
//            // Authentication passed
//            if (Auth::user()->role != "customer") {
//                Auth::logout(); // Log out the user immediately
//                return redirect()->route('account.login')
//                    ->with('error', 'Please Login with user credentials');
//            }
//            return redirect()->route('account.dashboard');
//
//        } else {
//            return redirect()->route('account.login')
//                ->with('error', 'Email or Password is Incorrect');
//        }
//    }
//
//    // Show registration form
//    public function register()
//    {
//        return view('register');
//    }
//
//    // Process registration
//    public function processRegister(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'name' => 'required',
//            'email' => 'required|email|unique:users',
//            'password' => 'required|min:6',
//            'password_confirmation' => 'required|same:password'
//        ]);
//
//        if ($validator->fails()) {
//            return redirect()->route('account.register')
//                ->withInput()
//                ->withErrors($validator);
//        }
//
//        $user = new User();
//        $user->name = htmlspecialchars($request->name);
//        $user->email = htmlspecialchars($request->email);
//        $user->password = Hash::make($request->password);
//        $user->role = 'customer'; // Assuming 'customer' is a string, you may need to adjust according to your role management
//        $user->save();
//
//        return redirect()->route('account.login')->with('success', 'Registration Successful');
//    }
//
//    // Log out user
//    public function logout()
//    {
//        Auth::logout();
//        return redirect()->route('account.login')->with('success', 'You have been logged out');
//    }
//}
