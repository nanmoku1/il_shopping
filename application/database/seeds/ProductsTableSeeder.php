<?php

use Faker\Factory as Fake;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Fake::create('ja_JP');
        for ($i = 1; $i <= 11; $i++) {
            DB::table('products')->insert([
                'id' => $i,
                'product_category_id' => $i+1,
                'name' => '商品'.$i,
                'price' => $fake->numberBetween(100, 100000),
                'description' => "説明{$i}\n説明{$i}説明{$i}説明{$i}\n\n説明{$i}",
                'created_at' => new Datetime(),
            ]);
        }
    }
}
