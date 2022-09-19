<?php

namespace Database\Seeders;

use App\Models\ItemReview;
use Illuminate\Database\Seeder;
use App\Models\Stock;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            AdminSeeder::class,
            OwnerSeeder::class,
            ShopSeeder::class,
            ImageSeeder::class,
            CategorySeeder::class,
            // ProductSeeder::class,
            // StockSeeder::class,
            UserSeeder::class,
            // ItemReviewSeeder::class,
        ]);

        Product::factory(100)->create();
        Stock::factory(100)->create();
        ItemReview::factory(100)->create();
    }
}
