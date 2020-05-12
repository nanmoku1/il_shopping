<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Fake;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Fake::create('ja_JP');
        for ($i = 0; $i < 13; $i++) {
            DB::table('product_categories')->insert([
                'name' => "カテゴリー".$fake->numberBetween(1, 100),
                'order_no' => $fake->numberBetween(1, 20),
                'created_at' => new Datetime(),
            ]);
        }
    }
}
