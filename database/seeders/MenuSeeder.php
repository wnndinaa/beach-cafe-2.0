<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
 
        $menus = [
            [
                'name' => 'Ais Jelly Limau',
                'price' => '4.00',
                'status' => 'Unvailable',
                'category' => 'Drink',
                'image_path' => 'ais-jelly-limau.jpeg',
                'created_at' => '2024-01-23', 
                'updated_at' => '2024-01-23',
            ],
            [
                'name' => 'French Fries',
                'price' => '5.00',
                'status' => 'Available',
                'category' => 'Side Dish',
                'image_path' => 'french-fries.jpg',
                'created_at' => $now, 
                'updated_at' => $now,
            ],
            [
                'name' => 'Mee Kari',
                'price' => '5.00',
                'status' => 'Available',
                'category' => 'Food',
                'image_path' => 'mee-kari.jpg',
                'created_at' => $now, 
                'updated_at' => $now,
            ],
            [
                'name' => 'Mee Kari Special',
                'price' => '7.00',
                'status' => 'Unavailable',
                'category' => 'Food',
                'image_path' => 'mee-kari-special.jpg',
                'created_at' => $now, 
                'updated_at' => $now,
            ],
            [
                'name' => 'Salad',
                'price' => '5.00',
                'status' => 'Available',
                'category' => 'Food',
                'image_path' => 'mix-salad.jpeg',
                'created_at' => $now, 
                'updated_at' => $now,
            ],
            [
                'name' => 'Mojito',
                'price' => '4.00',
                'status' => 'Available',
                'category' => 'Drink',
                'image_path' => 'mojito-straw-lemon.jpeg',
                'created_at' => $now, 
                'updated_at' => $now,
            ],
            [
                'name' => 'Mojito Lemon',
                'price' => '5.00',
                'status' => 'Unavailable',
                'category' => 'Drink',
                'image_path' => 'mojito-lemon-blue.jpeg',
                'created_at' => $now, 
                'updated_at' => $now,
            ],
            [
                'name' => 'Mojito Watermelon',
                'price' => '6.00',
                'status' => 'Available',
                'category' => 'Drink',
                'image_path' => 'mojito-watermelon.jpeg',
                'created_at' =>'2024-01-23', 
                'updated_at' => '2024-01-23',
            ],
            [
                'name' => 'Nasi Lemak Telur',
                'price' => '5.00',
                'status' => 'Unavailable',
                'category' => 'Food',
                'image_path' => 'nasi-lemak-telur.jpeg',
                'created_at' => $now, 
                'updated_at' => $now,
            ],
            [
                'name' => 'Nasi Lemak Ayam',
                'price' => '8.00',
                'status' => 'Available',
                'category' => 'Food',
                'image_path' => 'nasi-lemak-ayam.jpeg',
                'created_at' => $now, 
                'updated_at' => $now,
            ],
            [
                'name' => 'Oden',
                'price' => '5.00',
                'status' => 'Available',
                'category' => 'Food',
                'image_path' => 'oden.jpg',
                'created_at' => $now, 
                'updated_at' => $now,
            ],
            [
                'name' => 'Sandwich',
                'price' => '4.00',
                'status' => 'Available',
                'category' => 'Side Dish',
                'image_path' => 'sandwich.jpg',
                'created_at' => '2024-01-23', 
                'updated_at' => '2024-01-23',
            ],
        ];
      
        foreach ($menus as $menu) {
            DB::table('menus')->insert($menu);
        }
    }
}