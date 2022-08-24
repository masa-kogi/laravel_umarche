<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
            [
                'owner_id' => 1,
                'filename' => 'sample1.jpg',
            ],
            [
                'owner_id' => 1,
                'filename' => 'sample2.jpg',
            ],
            [
                'owner_id' => 1,
                'filename' => 'sample3.jpg',
            ],
            [
                'owner_id' => 1,
                'filename' => 'sample4.jpg',
            ],
            [
                'owner_id' => 1,
                'filename' => 'sample5.jpg',
            ],
            [
                'owner_id' => 1,
                'filename' => 'sample6.jpg',
            ],
        ]);
    }
}
