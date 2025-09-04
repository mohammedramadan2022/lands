<?php
namespace App\Services;

use App\Exceptions\NotFoundException;
use Illuminate\Support\Facades\DB;

class RankingService
{
    /**
     * Update rankings for a specific table.
     *
     * @param string $table
     * @param array $rankings
     * @return bool
     */
    public function updateRankings(string $table, array $rankings, int $userId): bool
    {
        $allowedTables = ['reviews', 'experiences', 'portfolios'];
        if (!in_array($table, $allowedTables)) {
            throw new \Exception("Table not allowed.");
        }

        DB::beginTransaction();

        try {
            foreach ($rankings as $id => $rank) {
                // Fetch the records
                $record = DB::table($table)->where('id', $id)->first();
                $rankRecord = DB::table($table)->where('id', $rank)->first();

                if (!$record) {
                    throw new \Exception("Record with ID {$id} not found in {$table}.");
                }
                if (!$rankRecord) {
                    throw new \Exception("Record with ID {$rank} not found in {$table}.");
                }

                // Authorization check
                switch ($table) {
                    case 'portfolios':
                    case 'experiences':
                        if ($record->user_id !== $userId) {
                            throw new \Exception("Unauthorized to update ranking for record ID {$id}.");
                        }
                        break;

                    case 'reviews':
                        $portfolio = DB::table('portfolios')->where('id', $record->portfolio_id)->first();
                        if (!$portfolio || $portfolio->user_id !== $userId) {
                            throw new \Exception("Unauthorized to update ranking for review ID {$id}.");
                        }
                        break;
                }

                $rank_old =  $rank;
                $id_old = $id;
                // Update rankings
                DB::table($table)
                    ->where('ranking', $rank_old)
                    ->update(['ranking' => -1]);

                DB::table($table)
                    ->where('ranking', $id_old)
                    ->update(['ranking' => $rank_old]);

                DB::table($table)
                    ->where('ranking', -1)
                    ->update(['ranking' => $id_old]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
