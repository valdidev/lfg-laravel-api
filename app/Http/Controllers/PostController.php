<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function sendPost(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $party = $request->get('party_id');
            $user = User::find($userId);
            $userParty = $user->party()->wherePivot('user_id', $userId)->find($party);

            if ($userParty) {
                $post = Post::create([
                    'message' => $request->get('message'),
                    'user_id' => $userId,
                    'party_id' => $party
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Post sent',
                    'data' => $post
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not member'
                ], 401);
            }
        } catch (\Throwable $th) {

            return response()->json([
                'success' => true,
                'message' => 'Could not send message'
            ], 500);
        }
    }
}
