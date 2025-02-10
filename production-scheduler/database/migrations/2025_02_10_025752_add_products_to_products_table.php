<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::table('products')->insert([
            ['id' => 1, 'name' => 'Product A', 'type' => 1, 'production_speed' => 715, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Product B', 'type' => 1, 'production_speed' => 715, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Product C', 'type' => 2, 'production_speed' => 770, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Product D', 'type' => 3, 'production_speed' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Product E', 'type' => 3, 'production_speed' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Product F', 'type' => 1, 'production_speed' => 715, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        DB::table('products')->whereIn('id', [1, 2, 3, 4, 5, 6])->delete();
    }
};
