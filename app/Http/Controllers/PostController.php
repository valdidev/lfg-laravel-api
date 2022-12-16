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
                    'party_id' => $party,
                    'is_visible' => true
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
                'success' => false,
                'message' => 'Could not send message'
            ], 500);
        }
    }

    // as delete function to common users
    public function changePostVisibility($id)
    {
        try {
            $userId = auth()->user()->id;
            $own = Post::where('user_id', $userId)->find($id);

            if ($own) {
                Post::where('id', $id)->update(['is_visible' => false]);
                return response()->json([
                    'success' => true,
                    'message' => 'Post deleted'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }
        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'message' => 'Could not delete message'
            ], 500);
        }
    }

    public function getAllPartyPosts($id)
    {
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            $userParty = $user->party()->wherePivot('user_id', $userId)->find($id);
            if ($userParty) {
                $messages = Post::where('party_id', $id)->orderBy('id', 'DESC')->select(['posts.message', 'posts.user_id', 'posts.created_at'])->with(['user:id,name'])->get();
                return response()->json([
                    'success' => true,
                    'data' => $messages
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission in that party'
                ], 401);
            }
        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'message' => 'Could not get messages'
            ], 500);
        }
    }

    public function editPost(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $postId = $request->get('id');
            $own = Post::where('user_id', $userId)->find($postId);
            if ($own) {
                $updatedPost = Post::where('id', $postId)->update([
                    'message' => $request->get('message')
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Post edited',
                    'data' => $updatedPost
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }
        } catch (\Throwable $th) {

            return response()->json([
                'success' => true,
                'message' => 'Could not edit message'
            ], 500);
        }
    }
}
