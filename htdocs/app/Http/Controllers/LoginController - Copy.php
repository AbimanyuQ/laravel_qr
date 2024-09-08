<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{

       /**
     * Handle the login attempt.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    // Show the login form
    public function showLoginForm()
    {
        return view('login'); // Adjust view path if necessary
    }

    // Handle the login request
public function login(Request $request)
{
    // Validate the form data
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Retrieve the user from the database
    $user = DB::table('users')->where('email', $request->input('email'))->first();

    // Check if the user exists
    if ($user) {
        // Attempt to log in the user
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ])) {
            // Authentication passed
            return response()->json(['message' => 'Login successful!']);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Login failed. Please check your credentials and try again.'], 401);
        }
    } else {
        // User not found
        return response()->json(['message' => 'User not found.'], 404);
    }
}


    // Logout the user
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logged out successfully!');
    }
}
