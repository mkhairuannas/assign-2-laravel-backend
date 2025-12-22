<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // logic untuk login
    // this function akan process email dan password user
    // this function akan keluarkan sanctum token
    // this function akan keluarkan response

    public function login(Request $request)
    {

        // validate the email and password
        // email and password are required
        $request->validate([
            'email' => 'required|email', // not uzzairwork, must be uzzairwork@gmail.com
            'password' => 'required'
        ]);
        // check user wujud atau tak di dalam database
        // || = or
        // && = and
        $user = User::where('email', $request->email)->first(); // dapatkan object user
        // dd($user);
        // kalau user tak wujud ATAU password mismatch, apa yang akan berlaku?
        // akan output mesej, "user is not authenticated"
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json('user is not authenticated');
        }
        // after everything is ok, create the user token
        // dapatkan user object dan seterusnya create sanctum token
        $token = $user->createToken('api-token')->plainTextToken;

        // return user data and the user's API/Bearer token
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    // dapatkan authenticated user's data
    // name the endppint as /me

    public function me()
    {
        $user = Auth::user();

        return response()->json([
            'data' => $user
        ],200);
    }
}
