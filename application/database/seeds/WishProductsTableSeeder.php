<?php

use Illuminate\Database\Seeder;

class WishProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wish_products')->insert([
            'user_id' => 3,
            'product_id' => 2,
        ]);
        DB::table('wish_products')->insert([
            'user_id' => 3,
            'product_id' => 4,
        ]);

        DB::table('wish_products')->insert([
            'user_id' => 4,
            'product_id' => 5,
        ]);

        DB::table('wish_products')->insert([
            'user_id' => 4,
            'product_id' => 6,
        ]);
    }
}
