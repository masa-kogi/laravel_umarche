<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('primary_categories')->insert([
            [
                'name' => '生理検査機器',
                'sort_order' => 1,
            ],
            [
                'name' => 'モニタリング機器',
                'sort_order' => 2,
            ],
            [
                'name' => '検体検査機器',
                'sort_order' => 3,
            ],
        ]);

        DB::table('secondary_categories')->insert([
            [
                'name' => '心電計',
                'sort_order' => 1,
                'primary_category_id' => 1
            ],
            [
                'name' => '脳波計',
                'sort_order' => 2,
                'primary_category_id' => 1
            ],
            [
                'name' => '画像診断機器',
                'sort_order' => 3,
                'primary_category_id' => 1
            ],
            [
                'name' => 'ベッドサイドモニタ',
                'sort_order' => 4,
                'primary_category_id' => 2
            ],
            [
                'name' => 'モニタリングシステム',
                'sort_order' => 5,
                'primary_category_id' => 2
            ],
            [
                'name' => '血流計',
                'sort_order' => 6,
                'primary_category_id' => 2
            ],
            [
                'name' => '血球計数機',
                'sort_order' => 7,
                'primary_category_id' => 3
            ],
            [
                'name' => 'CPR測定装置',
                'sort_order' => 8,
                'primary_category_id' => 3
            ],
            [
                'name' => '血液ガス・電解質分析装置',
                'sort_order' => 9,
                'primary_category_id' => 3
            ],
        ]);
    }
}
