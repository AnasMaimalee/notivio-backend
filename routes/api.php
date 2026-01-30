<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Course\CourseController;
use App\Http\Controllers\API\Jotting\JottingController;
use App\Http\Controllers\API\Attachment\AttachmentController;
use App\Http\Controllers\API\Jotting\SharedJottingController;
use App\Http\Controllers\API\Profile\ProfileController;
use App\Http\Controllers\API\Superadmin\AdminUserController;
use App\Http\Controllers\API\Superadmin\AdminDashboardController;
use App\Http\Controllers\API\Restore\RestoreController;
use App\Http\Controllers\API\Notification\NotificationController;
use App\Http\Controllers\API\Jotting\JottingVersionController;
use App\Http\Controllers\API\Trash\TrashController;
use App\Http\Controllers\API\Activity\ActivityController;
use App\Http\Controllers\API\Onboarding\OnboardingController;

// ---------------------
// Auth routes
// ---------------------
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

// users management 

Route::middleware(['auth:api', 'role:superadmin'])->prefix('admin')->group(function () {
    
    // User management
    Route::get('users', [AdminUserController::class, 'index']); // list all users
    Route::get('users/{user}', [AdminUserController::class, 'show']); // user details
    Route::put('users/{user}/role', [AdminUserController::class, 'updateRole']); // change role
    Route::put('users/{user}/status', [AdminUserController::class, 'updateStatus']); // deactivate / activate
    Route::delete('users/{user}', [AdminUserController::class, 'destroy']); // delete user

    // Login / session monitoring
    Route::get('users/{user}/logins', [AdminUserController::class, 'loginHistory']); // login history
    Route::get('users/{user}/sessions', [AdminUserController::class, 'sessions']); // active sessions
    Route::get('dashboard', [AdminDashboardController::class, 'index']);
});


// ---------------------
// Protected API routes
// ---------------------
Route::middleware('auth:api')->group(function () {

    // Courses
    Route::apiResource('courses', CourseController::class);

    // Jottings
    Route::apiResource('jottings', JottingController::class);

    // Jotting Versions
    Route::get('jottings/{jotting}/versions', [JottingController::class, 'versions']);
    Route::post('jottings/{jotting}/versions/{version}/restore', [JottingController::class, 'revertVersion']);

    // Attachments
    Route::prefix('jottings/{jotting}/attachments')->group(function () {
        Route::post('/', [AttachmentController::class, 'store']);
        Route::get('/', [AttachmentController::class, 'index']);
        Route::get('{attachment}', [AttachmentController::class, 'show']);
        Route::delete('{attachment}', [AttachmentController::class, 'destroy']);
        Route::get('attachments/{attachment}/download',[AttachmentController::class, 'download']);
        Route::get('attachments/{attachment}/stream',[AttachmentController::class, 'stream']
    );
    });

    // Shared Jottings
    Route::prefix('jottings/{jotting}/share')->group(function () {
        Route::post('/', [SharedJottingController::class, 'share']);
        Route::post('send-back', [SharedJottingController::class, 'sendBack']);
    });

    // Shared notes inbox
    Route::get('shared', [SharedJottingController::class, 'index']);

    // Profile
    Route::get('profile', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);
    Route::post('profile/change-password', [ProfileController::class, 'changePassword']);
    Route::post('profile/security', [ProfileController::class, 'updateSecurity']);
});

// ---------------------
// Superadmin-only routes
// ---------------------

Route::middleware('auth:api')->group(function () {
    Route::post('courses/{id}/restore', [RestoreController::class, 'restoreCourse']);
    Route::post('jottings/{id}/restore', [RestoreController::class, 'restoreJotting']);
    Route::post('attachments/{id}/restore', [RestoreController::class, 'restoreAttachment']);
});

// Notification 

Route::middleware('auth:api')->group(function () {
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::get('notifications/unread', [NotificationController::class, 'unread']);
    Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead']);

    //Jooting Version Restore
    Route::post('jottings/{jotting}/versions/{version}/restore',[JottingVersionController::class, 'restore']);

});

//Trash

Route::middleware('auth:api')->prefix('trash')->group(function () {
    Route::get('/', [TrashController::class, 'index']);
    Route::post('{type}/{id}/restore', [TrashController::class, 'restore']);
    Route::delete('{type}/{id}/force', [TrashController::class, 'forceDelete']);
});


// Activity 

Route::middleware('auth:api')->group(function () {
    Route::get('me/activity', [ActivityController::class, 'myActivity']);
});

Route::middleware(['auth:api', 'role:superadmin'])->group(function () {
    Route::get('admin/activity', [ActivityController::class, 'index']);
});

// onbaording 

Route::middleware('auth:api')->group(function () {
    Route::get('/themes/colors', [OnboardingController::class, 'listColors']);
    Route::post('/onboarding/theme', [OnboardingController::class, 'setTheme']);
});
