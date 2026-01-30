<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Jotting;
use App\Models\JottingShare;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'stats' => [
                'my_courses' => Course::where('user_id', $user->id)->count(),
                'my_jottings' => Jotting::where('user_id', $user->id)->count(),
                'shared_with_me' => JottingShare::where('shared_with', $user->id)->count(),
            ],

            'recent_jottings' => Jotting::where('user_id', $user->id)
                ->latest()
                ->limit(5)
                ->get(['id', 'title', 'updated_at']),
        ]);
    }
}
