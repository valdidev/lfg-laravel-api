<?php

namespace App\Http\Controllers;

use App\Models\MoreUserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserProfileController extends Controller
{
    // USER PROFILES - MORE INFO (SECONDARY DATA)
    public function fillMoreUserInfo(Request $request)
    {

        try {

            $userId = auth()->user()->id;

            $moreInfo = MoreUserInfo::create([
                'surname' => $request->get('surname'),
                'age' => $request->get('age'),
                'steam_account' => $request->get('steam_account'),
                'user_id' => $userId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User profile filled successfully',
                'data' => $moreInfo
            ], 200);
        } catch (\Throwable $th) {
            Log::error('ERROR - filling more info user' . $th);
            return response()->json([
                'success' => true,
                'message' => 'User profile could not be filled'
            ], 500);
        }
    }

    public function updateMoreUserInfo(Request $request)
    {

        try {
            $userId = auth()->user()->id;
            $fullUser = MoreUserInfo::where('user_id', $userId)->update([
                'surname' => $request->get('surname'),
                'age' => $request->get('age'),
                'steam_account' => $request->get('steam_account'),
                'user_id' => $userId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User profile updated successfully',
                'data' => $fullUser
            ]);
        } catch (\Throwable $th) {
            Log::error("Error updating user: " . $th->getMessage());

            return response()->json([
                'success' => true,
                'message' => 'User data could not be updated'
            ], 500);
        }
    }
    // GET FULL PROFILE - MAIN AND SECONDARY DATA
    public function getFullProfile()
    {
        try {
            $userId = auth()->user()->id;

            $fullUser = MoreUserInfo::select('surname', 'age', 'steam_account')->with('user:id,email')->find($userId);

            return response()->json([
                'success' => true,
                'message' => 'Profile successfully retrieved',
                'data' => $fullUser
            ]);
        } catch (\Throwable $th) {
            Log::error("Error retrieving user: " . $th->getMessage());

            return response()->json([
                'success' => true,
                'message' => 'User could not be retrieved'
            ], 500);
        }
    }
}
