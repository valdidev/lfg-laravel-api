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

            $newParty->users()->attach($userId, ['is_owner' => true, 'is_active' => true]);

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

    public function leaveParty($id)
    {
        try {
            $userId = auth()->user()->id;
            $party = Party::find($id);
            $owner = $party->users()->wherePivot('is_owner', true)->find($userId);
            if ($owner) {
                return response()->json([
                    'success' => false,
                    'message' => 'The owner cant leave the party'
                ]);
            } else {
                $party->users()->updateExistingPivot($userId, ['is_owner' => false, 'is_active' => false]);
                return response()->json([
                    'success' => true,
                    'message' => 'Leaving of the party...',
                ]);
            }
        } catch (\Throwable $th) {

            return response()->json([
                'success' => true,
                'message' => 'Could not leave party'
            ], 500);
        }
    }


}
