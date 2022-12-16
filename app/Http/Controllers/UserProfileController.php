<?php

namespace App\Http\Controllers;

use App\Models\MoreUserInfo;
use App\Models\User;
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

            $info = User::where('id', $userId)->select('users.name', 'users.email')->get();

            $moreInfo = MoreUserInfo::where('user_id', $userId)->select('more_users_info.surname', 'more_users_info.age', 'more_users_info.steam_account')->get();

            return response()->json([
                'success' => true,
                'message' => 'profile brought successfully',
                'data' => compact('info', 'moreInfo')
            ], 200);
        } catch (\Throwable $th) {
            Log::error("Error getting user: " . $th->getMessage());

            return response()->json([
                'success' => true,
                'message' => 'User could not be getted'
            ], 500);
        }
    }
}
