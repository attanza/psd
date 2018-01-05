<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('passport:install');
        $this->call(LaratrustSeeder::class);
        $this->call(PsdSeed::class);
        $this->call(StoreSeed::class);
        // $this->call(OutletSeed::class);
    }
}
