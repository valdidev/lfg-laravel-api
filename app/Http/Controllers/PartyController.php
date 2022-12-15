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

    public function getPartiesByGameId($id)
    {
        try {
            $parties = Party::where('game_id', $id)->get();

            return response()->json([
                'success' => true,
                'message' => 'Parties found',
                'data' => $parties
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'success' => true,
                'message' => 'Could not get parties'
            ], 500);
        }
    }

    public function joinParty($id)
    {
        try {
            $userId = auth()->user()->id;
            $party = Party::find($id);

            $party->users()->attach($userId, ['is_owner' => false, 'is_active' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Party joined',
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'success' => true,
                'message' => 'Could not join party'
            ], 500);
        }
    }
}
