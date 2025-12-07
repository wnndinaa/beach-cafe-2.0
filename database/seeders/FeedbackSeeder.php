<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $now = now();

        for ($i=0; $i < 20; $i++) { 
            $randUser = rand(3,5);
            $randMenu = rand(1,10);
            $randRate = rand(1, 5);
            $randDate = Carbon::now()->subDays(rand(0, 365));

            DB::table('feedback')->insert([
                ['user_id' => $randUser, 'menu_id' => $randMenu,'comment' => 'comment lah pape pon','rating' => $randRate,'date' => $randDate, 'created_at' => $now, 'updated_at' => $now],
            ]);
        }
    }
}
