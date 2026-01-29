<?php

namespace App\Http\Controllers\API\Activity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    // Admin: see everything
    public function index()
    {
        return response()->json(
            Activity::with('causer')
                ->latest()
                ->paginate(30)
        );
    }

    // User: see only their own actions
    public function myActivity(Request $request)
    {
        return response()->json(
            Activity::where('causer_id', $request->user()->id)
                ->latest()
                ->paginate(30)
        );
    }
}
