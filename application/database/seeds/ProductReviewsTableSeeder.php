<?php

use Illuminate\Database\Seeder;

class ProductReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_reviews')->insert([
            'user_id' => 3,
            'product_id' => 2,
            'title' => '削除確認用タイトル3_2',
            'body' => '削除確認用本文3_2',
            'rank' => 1,
            'created_at' => new Datetime(),
        ]);
        DB::table('product_reviews')->insert([
            'user_id' => 3,
            'product_id' => 4,
            'title' => '削除確認用タイトル3_4',
            'body' => '削除確認用本文3_4',
            'rank' => 2,
            'created_at' => new Datetime(),
        ]);

        DB::table('product_reviews')->insert([
            'user_id' => 4,
            'product_id' => 5,
            'title' => '削除確認用タイトル4_5',
            'body' => '削除確認用本文4_5',
            'rank' => 3,
            'created_at' => new Datetime(),
        ]);

        DB::table('product_reviews')->insert([
            'user_id' => 4,
            'product_id' => 6,
            'title' => '削除確認用タイトル4_6',
            'body' => '削除確認用本文4_6',
            'rank' => 4,
            'created_at' => new Datetime(),
        ]);
    }
}
