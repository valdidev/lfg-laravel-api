<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    public function createGame(Request $request)
    {
        try {

            $userId = auth()->user()->id;

            $game = Game::create([
                'name' => $request->get('name'),
                'genre' => $request->get('genre'),
                'platform' => $request->get('platform'),
                'user_id' => $userId
            ]);
            
            
            return response()->json([
                'success' => true,
                'message' => 'Game created',
                'data' => $game
            ]);
        } catch (\Throwable $th) {
            Log::error('Something went wrong creating new game...'.$th->getMessage());
            return response()->json([
                'success' => true,
                'message' => 'Game could not be created'
            ], 500);
        }
    }
}
