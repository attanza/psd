<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
        $this->call(AreaSeed::class);
        $this->call(MarketSeed::class);
        $this->call(ProductSeed::class);
        $this->call(StokistSeed::class);

    }
}
