<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the current time
        $now = now();
        $lastweek = now()->subWeek();
        $lastmonth = now()->subMonth()->endOfMonth();

        // Define 10 manually created orders
        $orders = [
            [
                'user_id' => 3, 
                'order_status' => 'success', 
                'order_total' => 20.00, 
                'order_date' => '2023-01-23',
                'order_time' => $now,  // 3 days ago
                'created_at' => '2023-01-23',
                'updated_at' => '2023-01-23',
            ],
            [
                'user_id' => 3, 
                'order_status' => 'success', 
                'order_total' => 15.50, 
                'order_date' => '2023-01-23',
                'order_time' => $now,  // 5 days ago
                'created_at' => $lastmonth,
                'updated_at' => $lastmonth,
            ],
            [
                'user_id' => 3, 
                'order_status' => 'success', 
                'order_total' => 0.00,  // No charge for cancelled order
                'order_time' => $now,  // 7 days ago
                'order_date' => '2023-01-23',
                'created_at' => $lastmonth,
                'updated_at' => $lastmonth,
            ],
            [
                'user_id' => 4, 
                'order_status' => 'success', 
                'order_total' => 50.00, 
                'order_time' => $now,  // 10 days ago
                'order_date' => '2023-01-23',
                'created_at' => $lastweek,
                'updated_at' => $lastweek,
            ],
            [
                'user_id' => 4, 
                'order_status' => 'success', 
                'order_total' => 30.00, 
                'order_time' => $now,  // 2 days ago
                'created_at' => '2023-01-23',
                'order_date' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 4, 
                'order_status' => 'success', 
                'order_total' => 12.50, 
                'order_time' => $now,  // 8 days ago
                'created_at' => '2023-01-23',
                'order_date' => '2023-01-23',
                'updated_at' => '2023-01-23',
            ],
            [
                'user_id' => 5, 
                'order_status' => 'success', 
                'order_total' => 22.00, 
                'order_time' => $now,  // 1 day ago
                'created_at' => '2023-01-23',
                'order_date' => $lastweek,
                'updated_at' => $lastweek,
            ],
            [
                'user_id' => 5, 
                'order_status' => 'success', 
                'order_total' => 45.00, 
                'order_time' => $now,  // 6 days ago
                'created_at' => '2023-01-23',
                'order_date' => $lastweek,
                'updated_at' => $lastweek,
            ],
            [
                'user_id' => 5, 
                'order_status' => 'success', 
                'order_total' => 60.00, 
                'order_time' => $now,  // 4 days ago
                'created_at' => '2023-01-23',
                'order_date' => '2023-01-23',
                'updated_at' => '2023-01-23',
            ],
            [
                'user_id' => 4, 
                'order_status' => 'success', 
                'order_total' => 25.00, 
                'order_time' => $now,  // 9 days ago
                'created_at' => '2023-01-23',
                'order_date' => $lastmonth,
                'updated_at' => $lastmonth,
            ]
        ];

        // Insert the orders into the orders table
        DB::table('orders')->insert($orders);
    }
}
