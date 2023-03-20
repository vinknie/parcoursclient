<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertMonthlyTotalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:monthly-total';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // fetching data from verbatim table
        $monthlyTotals = DB::table('verbatim')
            ->select(
                DB::raw('SUM(positif) as total_positif, 
                    SUM(negatif) as total_negatif, 
                    id_verbatim')
            )
            ->groupBy('id_verbatim')
            ->get();

        // inserting into historiques table
        foreach ($monthlyTotals as $total) {
            DB::table('historiques')->insert([
                'id_verbatim' => $total->id_verbatim,
                'month_year' => Carbon::now()->month . '-' . Carbon::now()->year,
                'positif' => $total->total_positif,
                'negatif' => $total->total_negatif,
            ]);
        }
    }
}
