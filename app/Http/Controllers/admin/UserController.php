<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Display a listing of the users
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('admin.user.list', compact('users'));
    }

    // Show the form for creating a new user
    public function create()
    {
        return view('admin.user.create');
    }

    // Store a newly created user in storage
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:customer,admin',
            'status' => 'required|integer|in:0,1',
        ]);

        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->role = $request->input('role');
            $user->status = $request->input('status');

            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'User has been created successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    // Show the form for editing the specified user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    // Update the specified user in storage
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:customer,admin',
            'status' => 'required|integer|in:0,1',
        ]);

        if ($validator->passes()) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->role = $request->input('role');
            $user->status = $request->input('status');

            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'User has been updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

//    // Remove the specified user from storage
//    public function destroy($id)
//    {
//        $user = User::findOrFail($id);
//        $user->delete();
//
//        return response()->json([
//            'status' => true,
//            'message' => 'User has been deleted successfully',
//        ]);
//    }
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false], 404);
        }
    }

}
