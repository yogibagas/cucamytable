<?php

use Illuminate\Database\Seeder;

class MenuCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('menu_categories')->insert([
            'menu_group' => 'FOOD',
            'name' => 'Tapas',
            'status'=> 1,
        ]);
        DB::table('menu_categories')->insert([
            'menu_group' => 'FOOD',
            'name' => 'Canape Reception',
            'status'=> 1,
        ]);
        DB::table('menu_categories')->insert([
            'menu_group' => 'FOOD',
            'name' => 'Main Course',
            'status'=> 1,
        ]);
        DB::table('menu_categories')->insert([
            'menu_group' => 'FOOD',
            'name' => 'Dessert',
            'status'=> 1,
        ]);
        DB::table('menu_categories')->insert([
            'menu_group' => 'BEVERAGE',
            'name' => 'Cocktail',
            'status'=> 1,
        ]);
        DB::table('menu_categories')->insert([
            'menu_group' => 'BEVERAGE',
            'name' => 'Mocktail',
            'status'=> 1,
        ]);
        DB::table('menu_categories')->insert([
            'menu_group' => 'BEVERAGE',
            'name' => 'Beer',
            'status'=> 1,
        ]);
        DB::table('menu_categories')->insert([
            'menu_group' => 'BEVERAGE',
            'name' => 'Soft Drink',
            'status'=> 1,
        ]);
        DB::table('menu_categories')->insert([
            'menu_group' => 'BEVERAGE',
            'name' => 'Water',
            'status'=> 1,
        ]);
        DB::table('menu_categories')->insert([
            'menu_group' => 'BEVERAGE',
            'name' => 'Juice',
            'status'=> 1,
        ]);
    }
}
