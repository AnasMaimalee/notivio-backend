<?php

namespace App\Http\Controllers\API\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Jotting;
use App\Models\JottingShare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        /** =========================
         *  USERS
         * ========================= */
        $totalUsers = User::count();
        $activeUsers = User::where('active', true)->count();

        $recentUsers = User::latest()
            ->take(5)
            ->get([
                'id',
                'name',
                'email',
                'role',
                'active',
                'last_login_at',
                'created_at',
            ]);

        /** =========================
         *  COURSES
         * ========================= */
        $totalCourses = Course::count();

        /** =========================
         *  JOTTINGS
         * ========================= */
        $totalJottings = Jotting::count();

        /** =========================
         *  SHARED JOTTINGS
         * ========================= */
        $jottingShare = JottingShare::count();

        /** =========================
         *  TRASH (Soft Deletes)
         * ========================= */
        $trashedCourses = Course::onlyTrashed()->count();
        $trashedJottings = Jotting::onlyTrashed()->count();

       

        /** =========================
         *  RESPONSE
         * ========================= */
        return response()->json([
            'stats' => [
                'total_users' => $totalUsers,
                'active_users' => $activeUsers,
                'total_courses' => $totalCourses,
                'total_jottings' => $totalJottings,
                'shared_jottings' => $jottingShare,
                'trashed_items' => $trashedCourses + $trashedJottings,
            ],

            'recent_users' => $recentUsers,

        ]);
    }
}
