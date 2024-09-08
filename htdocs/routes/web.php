<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;



    Route::get('/checkin/{userId}', function () {
        return view('checkin');
    });

    Route::get('/checkout/{userId}', function () {
        return view('checkout');
    });


Route::get("/userslist", [UserController::class, "showuser"])->name(
    "userslist"
);

// Handle the user registration
// web.php


Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/check-status/{userId}', [UserController::class, 'checkStatus']);


// Validate user ID for QR code generation
Route::post("/validate-user", [UserController::class, "validateUser"])->name(
    "validate.user"
);

Route::get("/", function () {
    return view("welcome");
});

Route::get("/login", function () {
    return view("login");
});



Route::get("/users", function () {
    return view("users");
});

Route::get('/checkin/{userId}', function () {
    return view('checkin');
});


Route::get('/checkout/{userId}', function () {
    return view('checkout');
});



// Route::post('/login', [LoginController::class, 'login']);

// Handle logout




Route::post('/checkinout', [UserController::class, 'handleCheckInOut']);



Route::post('/checkinoutdata', [UserController::class, 'checkinout']);

Route::post('/login_data', [LoginController::class, 'login']);

Route::get("/qr-code-view", [AttendanceController::class, "generateQRCode"]);


// Protect dashboard and other routes with auth middleware
Route::middleware(['auth'])->group(function () {

    // Add other routes that should be protected by the 'auth' middleware here
Route::post("/register", [UserController::class, "registerUser"]);

Route::get("/login", function () {
    return view("login");
});

// web.php
Route::get("/userslistview", [UserController::class, "getUsers"]);


});

Route::get('/login', function () {
    return view('login');
})->name('login');



// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/userslist', function () {
        return view('userslist');
    })->name('users');

    Route::get("/register", function () {
    return view("register");
});


});

// Route::get('/login', function () {
//     return view('login');
// })->middleware('guest');

// Protected routes
// Route::middleware(['auth'])->group(function () {
//     Route::get('/register', function () {
//         return view('register');
//     });
// });



// Routes that should only be accessible to guests (unauthenticated users)
// Route::middleware(['auth'])->group(function () {
//     Route::get('/users', [UserController::class, 'showUsers'])->name('users'); // Example protected route
// });