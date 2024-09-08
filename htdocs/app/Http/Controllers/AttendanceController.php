<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceLog;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceController extends Controller
{
    public function checkIn(Request $request, $userId)
    {
        // Check if the user exists in the database
        $user = DB::table("users")->where("id", $userId)->first();

        if (!$user) {
            return response()->json(["message" => "User not found"], 404);
        }

        // Insert a new check-in record for the user
        DB::table("records")->insert([
            "user_id" => $user->id,
            "check_in" => Carbon::now(),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        return response()->json(["message" => "User checked in successfully"]);
    }

    // Function to check out a user using their record ID
    public function checkOut(Request $request, $recordId)
    {
        // Find the record by ID
        $record = DB::table("records")->where("id", $recordId)->first();

        if (!$record) {
            return response()->json(["message" => "Record not found"], 404);
        }

        // Update the check-out time for the record
        DB::table("records")
            ->where("id", $recordId)
            ->update([
                "check_out" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);

        return response()->json(["message" => "User checked out successfully"]);
    }
}
