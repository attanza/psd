<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 25)->create();
    }
}
