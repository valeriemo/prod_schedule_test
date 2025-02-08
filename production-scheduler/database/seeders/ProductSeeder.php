<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('products')->insert([
            ['name' => 'Product A', 'type' => 1, 'production_speed' => 715],
            ['name' => 'Product B', 'type' => 1, 'production_speed' => 715],
            ['name' => 'Product C', 'type' => 2, 'production_speed' => 770],
            ['name' => 'Product D', 'type' => 3, 'production_speed' => 1000],
            ['name' => 'Product E', 'type' => 3, 'production_speed' => 1000],
            ['name' => 'Product F', 'type' => 1, 'production_speed' => 715],
        ]);
    }
}
