<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::get("/", [UserController::class, "index"])->name('index');
        Route::post("/start-work", [UserController::class, "startWork"]);
        Route::post("/end-work",[UserController::class, "endWork"]);
        Route::post("/start-break", [UserController::class, "startBreak"]);
        Route::post("/end-break", [UserController::class, "endBreak"]);
        Route::get("/date", [UserController::class, "date"]);
        Route::get("/date/add-date", [UserController::class, "addDate"]);
        Route::get("/date/sub-date", [UserController::class, "subDate"]);
        Route::get("/users", [UserController::class, "users"]);
        Route::get("/users/detail", [UserController::class, "detail"])->name("detail");
        Route::get("/users/detail/add-date", [UserController::class, "addDateOnDetail"])->name("addDate");
        Route::get("/users/detail/sub-date", [UserController::class, "subDateOnDetail"])->name("subDate");
    });


require __DIR__.'/auth.php';
