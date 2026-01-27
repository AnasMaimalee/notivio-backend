<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Course\CourseController;
use App\Http\Controllers\API\JottingController;
use App\Http\Controllers\API\AttachmentController;
use App\Http\Controllers\API\SharedJottingController;

// Auth routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

// Protected API routes
Route::middleware('auth:api')->group(function () {

    // Courses
    Route::apiResource('courses', CourseController::class);

    // Jottings
    Route::apiResource('jottings', JottingController::class);

    // Attachments
    Route::prefix('jottings/{jotting}/attachments')->group(function () {
        Route::post('/', [AttachmentController::class, 'store']);
        Route::get('/', [AttachmentController::class, 'index']);
        Route::get('{attachment}', [AttachmentController::class, 'show']);
        Route::delete('{attachment}', [AttachmentController::class, 'destroy']);
    });

    Route::get('jottings/{jotting}/versions', [JottingVersionController::class, 'index']);
    Route::post('jottings/{jotting}/versions/{version}/restore', [JottingVersionController::class, 'restore']);


    // Shared Jottings
    Route::prefix('jottings/{jotting}/share')->group(function () {
        Route::post('/', [SharedJottingController::class, 'share']);
        Route::post('send-back', [SharedJottingController::class, 'sendBack']);
    });

    // Shared notes inbox
    Route::get('shared', [SharedJottingController::class, 'index']);
});

// Superadmin-only routes
Route::middleware(['auth:api', 'role:superadmin'])->group(function () {
    Route::get('admin/users', [CourseController::class, 'listUsers']); // example
    Route::get('admin/analytics', [CourseController::class, 'analytics']); // example
});


Route::middleware('auth:api')->group(function () {
    Route::get('profile', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);
    Route::post('profile/change-password', [ProfileController::class, 'changePassword']);
    Route::post('profile/security', [ProfileController::class, 'updateSecurity']);
});
