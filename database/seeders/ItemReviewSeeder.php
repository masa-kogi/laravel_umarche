<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ItemReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_reviews')->insert([
            [
                'item_id' => 1,
                'user_id' => 1,
                'rating' => 4,
                'comment' => '買って良かったです！'
            ],
            [
                'item_id' => 3,
                'user_id' => 1,
                'rating' => 3,
                'comment' => '可もなく不可もなく。'
            ],
        ]);
    }
}
