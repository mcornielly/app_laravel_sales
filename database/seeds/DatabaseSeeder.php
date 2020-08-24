<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call([
            UsersTableSeeder::class, 
            CategoriesTableSeeder::class,
            ProductsTableSeeder::class,
            CustomersTableSeeder::class,
            ProvidersTableSeeder::class,
            SalesTableSeeder::class,
            IncomeTableSeeder::class,
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
