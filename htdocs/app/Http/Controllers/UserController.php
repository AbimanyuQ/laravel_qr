<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Show the registration form
    public function showRegisterForm()
    {
        return view("register"); // Render the registration form view
    }

    public function showuser()
    {
        return view("userslist"); // Render the registration form view
    }


    public function getUsers()
    {
        // $users = DB::table("users")->get();
        // dd($users);

           $users = DB::table('users')
        ->leftJoin(
            DB::raw('(SELECT id, user_id, action, timestamp 
                      FROM user_checkin_checkout 
                      WHERE (user_id, timestamp) IN 
                          (SELECT user_id, MAX(timestamp) 
                           FROM user_checkin_checkout 
                           GROUP BY user_id)
                     ) as latest_actions'), 
            'users.id', '=', 'latest_actions.user_id'
        )
        ->select(
            'users.id', 
            'users.name', 
            'users.email', 
            'latest_actions.action', 
            'latest_actions.timestamp'
        )
        ->get();

        // Return users as JSON response
        return response()->json($users);
    }


public function checkStatus($userId)
{
    $status = DB::table('user_checkin_checkout')
        ->where('user_id', $userId)
        ->latest('timestamp') // Use the timestamp column to get the latest entry
        ->first();

    if (!$status) {
        return response()->json([
            'message' => 'User has no check-in or check-out record.',
            'action' => null,
        ]);
    }

    $latestAction = $status->action;

    return response()->json([
        'message' => "User is currently {$latestAction}.",
        'action' => $latestAction,
    ]);
}

    public function handleCheckInOut(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'action' => 'required|in:checkin,checkout',
        ]);

        // dd($request);

        // Insert the check-in or check-out record
        DB::table('user_checkin_checkout')->insert([
            'user_id' => $request->user_id,
            'action' => $request->action,
            'timestamp' => now(),
        ]);

        return response()->json(['message' => ucfirst($request->action) . ' recorded successfully.']);
    }


public function checkinout(Request $request)
{
    $userId = $request->input('user_id');
    $action = $request->input('action');

    // Validate input
    if (!in_array($action, ['checkin', 'checkout'])) {
        return response()->json(['message' => 'Invalid action.'], 400);
    }

    try {
        // Insert the check-in/check-out record
        // DB::table('user_checkin_checkout')->insert([
        //     'user_id' => $userId,
        //     'action' => $action,
        //     'timestamp' => now(),
        // ]);

        // Retrieve the latest entry for the user
        $latestRecord = DB::table('user_checkin_checkout')
            ->where('user_id', $userId)
            ->latest('timestamp')
            ->first();

        // Determine the action message
        $actionMessage = ucfirst($latestRecord->action) . ' successful!';

        return response()->json([
            'message' => $actionMessage,
            'action' => $latestRecord->action,
        ]);
    } catch (\Exception $e) {
        // Handle any errors during the insertion
        return response()->json(['message' => 'Failed to perform action.'], 500);
    }
}



    // Register a new user and generate a QR code
    public function registerUser(Request $request)
    {
        // Validate the input data
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:6|confirmed",
        ]);

        // dd($request);
        // Hash the password
        $hashedPassword = Hash::make($request->password);

        // Insert the new user into the database
        $userId = DB::table("users")->insertGetId([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $hashedPassword,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        // Return the hashed password as JSON response
        return response()->json(["hashed_password" => $hashedPassword]);
    }
}
