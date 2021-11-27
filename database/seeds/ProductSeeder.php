<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 100)->make();
        factory(App\User::class, 100)->create();

   

       factory(App\Category::class, 20)
       ->create()
        ->each(function ($category) {
            $category->products()->createMany(
                    factory(App\Product::class, 50)->make()->toArray()

            );
         });

    }
}
