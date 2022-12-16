<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    const USER_ROLE_ID = 1;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()
            ], 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->password),
            'role_id' => 1,
            'is_enabled' => true
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = null;
        $validation = $jwt_token = JWTAuth::attempt($input);

        if (!$validation) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'success' => true,
            'token' => $jwt_token
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Logged out']);
    }

    public function disableAccount()
    {
        try {
            $userId = auth()->user()->id;

            DB::table('users')
                ->where('id', $userId)
                ->update(['is_enabled' => false]);

            auth()->logout();

            return response()->json([
                'success' => true,
                'message' => 'Your account has been deleted'
            ], 200);
        } catch (\Throwable $th) {
            Log::error('ERROR - Disabling account - ' . $th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong disabling that account'
            ], 500);
        }
    }
}
