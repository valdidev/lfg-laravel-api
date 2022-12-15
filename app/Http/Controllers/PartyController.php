<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    public function createParty(Request $request)
    {
        try {
            $userId = auth()->user()->id;

            $newParty = Party::create([
                'name' => $request->get('name'),
                'game_id' => $request->get('game_id')
            ]);

            // $newParty->user()->attach($userId);

            return response()->json([
                'success' => true,
                'message' => 'Party created',
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'success' => true,
                'message' => 'Party could not be created'
            ], 500);
        }
    }

    
}
