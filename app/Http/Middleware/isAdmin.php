<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class isAdmin
{
    public function handle(Request $request, Closure $next)
    {
        Log::info("Middleware isAdmin running");

        $userId = auth()->user()->id;
        $user = User::find($userId);

        if ($user->role_id != 2) {
            Log::error('Unauthorized tried by'. $user->email);
            return response()->json([
                'success' => true,
                'message' => "Unauthorized"
            ]);
        }

        return $next($request);
    }
}
