<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function storeVote(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'barcode' => 'required|string',
                'votes' => 'required|array',
                'votes.*.member_id' => 'required|exists:members,id',
                'votes.*.vote' => 'required|string'
            ]);

            // Start a database transaction
            DB::beginTransaction();

            foreach ($request->votes as $voteData) {
                // Parse the vote value (format: "type-memberId")
                list($voteType, $memberId) = explode('-', $voteData['vote']);

                // Create vote record
                Vote::create([
                    'barcode' => $request->barcode,
                    'member_id' => $memberId,
                    'vote_type' => $voteType, // 1 for عمانية, 2 for مهجنة
                    'user_id' => auth()->id() // Assuming you want to track who made the vote
                ]);
            }

            // Commit the transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم حفظ التصويت بنجاح'
            ]);

        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حفظ التصويت',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
