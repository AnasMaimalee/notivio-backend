<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'role' => 'user',
        ]);

        

        return response()->json(['user' => $user], 201);
    }

    /**
     * Login user and return token + menus + permissions + role
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = auth('api')->user();
        $role = $user->role;

        // Get menus from config
        $menus = config('menus.' . $role, []);

        // Define permissions (can expand in future)
        $permissions = $this->getPermissionsByRole($role);

        return response()->json([
            'token' => $token,
            'user' => $user,
            'role' => $role,
            'menus' => $menus,
            'permissions' => $permissions
        ]);
    }

     /**
     * Logout user (invalidate token)
     */
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

      /**
     * Forgot password - send reset link
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 500);
    }

    /**
     * Reset password using token
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 500);
    }

    /**
     * Helper: define permissions based on role
     */
    private function getPermissionsByRole($role)
    {
        if ($role === 'superadmin') {
            return [
                'manage_users' => true,
                'manage_courses' => true,
                'manage_jottings' => true,
                'view_shared_notes' => true,
                'analytics' => true,
            ];
        }

        return [
            'create_course' => true,
            'create_jotting' => true,
            'edit_own_jotting' => true,
            'view_shared_notes' => true,
            'favorite_jottings' => true,
        ];
    }


    public function me()
    {
        $user = auth('api')->user();

        // Determine role
        $role = $user->role;

        // Get menus for role
        $menus = config('menus.' . $role, []);

        // Define permissions (can be extended)
        $permissions = [];
        if ($role === 'superadmin') {
            $permissions = [
                'manage_users' => true,
                'manage_courses' => true,
                'manage_jottings' => true,
                'view_shared_notes' => true,
                'analytics' => true,
            ];
        } else {
            $permissions = [
                'create_course' => true,
                'create_jotting' => true,
                'edit_own_jotting' => true,
                'view_shared_notes' => true,
                'favorite_jottings' => true,
            ];
        }

        return response()->json([
            'user' => $user,
            'role' => $role,
            'menus' => $menus,
            'permissions' => $permissions,
        ]);
    }

}


