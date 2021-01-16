<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterFormRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function register(RegisterFormRequest $request)
    {
        $request->merge(['password' => bcrypt($request->password)]);

        User::create($request->post());

        return response()->json([
            'message' => 'You were successfully registered. Use your email and password to sign in.'
        ], 200);

    }

    public function login(Request $request)
    {
        if ($request->has('name')) {
            $credentials = $request->only('password', 'name');
        } else {
            $credentials = $request->only('email', 'password');
        }

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'You cannot sign with those credentials',
                'errors' => 'Unauthorised'], 401);
        }
        $token = Auth::user()->createToken(config('app.name'));
        $token->token->expires_at = $request->remember_me ?
            Carbon::now()->addMonth() :
            Carbon::now()->addDay();

        $token->token->save();

        return response()->json([
            'token_type' => 'Bearer',
            'token' => $token->accessToken,
            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString()
        ], 200);

    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'You are successfully logged out',
            'status' => 200
        ]);

    }

}
