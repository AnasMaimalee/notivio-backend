<?php

namespace App\Http\Controllers\API\Superadmin;

use App\Models\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Users Retrieved Successfully',
            'data' => User::all()
        ]);
    }

    public function show(User $user)
    {
        return response()->json([
            'message' => 'User Retrieved Successfully',
            'data' => $user
        ]);
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:user,superadmin']);
        $user->update(['role' => $request->role]);

        return response()->json(['message' => 'Role updated', 'user' => $user]);
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate(['status' => 'required|in:active,inactive,suspended']);
        $user->update(['status' => $request->status]);

        return response()->json(['message' => 'Status updated', 'user' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }

    public function loginHistory(User $user)
    {
        $logins = $user->loginAttempts()->orderByDesc('created_at')->get();
        return response()->json([
            'message' => 'Login History Retrieved Successfully',
            'data' => $logins
        ]);
    }


    public function sessions(User $user)
    {
        $sessions = Session::where('user_id', $user->id)->get();
        return response()->json($sessions);
    }
}
