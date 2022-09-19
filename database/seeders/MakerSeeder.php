<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('makers')->insert([
            [
                'name' => '日本光電',
            ],
            [
                'name' => 'フクダ電子',
            ],
            [
                'name' => 'Phillips',
            ],
            [
                'name' => 'GE',
            ],
            [
                'name' => 'Mindray',
            ],
            [
                'name' => 'Medtronic',
            ],
            [
                'name' => 'Siemens',
            ],
            [
                'name' => 'オリンパス',
            ],
        ]);
    }
}
