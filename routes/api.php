<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\StudentController;
use App\Http\Middleware\v1\ProtectedRouteAuth;

Route::prefix('v1/')->group(function() {

    /* Route Status */
    Route::get('status', function() { return response()->json(['api_name' => 'apirestjwt-students', 'status' => true], 200); });

    /* Route Authentication */
    Route::post('auth/login', [AuthController::class, 'login']);

    Route::middleware([ProtectedRouteAuth::class])->group(function() {

        /* Route Products */
        Route::post('student', [StudentController::class, 'create']);
        Route::get('students', [StudentController::class, 'readAll']);
        Route::get('student/{id}', [StudentController::class, 'read']);
        Route::put('student/{id}', [StudentController::class, 'update']);
        Route::delete('student/{id}', [StudentController::class, 'delete']);

    });
        
});