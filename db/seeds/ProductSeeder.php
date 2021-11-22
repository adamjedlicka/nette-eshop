<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class ProductSeeder extends AbstractSeed
{
    const PRODUCTS = 100;

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $faker = Factory::create();

        $data = [];

        for ($i = 0; $i < self::PRODUCTS; $i++) {
            $data[] = [
                'name' => $faker->sentence($faker->numberBetween(1, 4)),
                'description' => $faker->text(),
                'price' => $faker->randomNumber(6),
                'slug' => $faker->unique()->slug(),
            ];
        }

        $this->table('product')->insert($data)->saveData();

        $pivot = [];

        for ($i = 1; $i <= self::PRODUCTS; $i++) {
            $pivot[] = [
                'category_id' => $faker->numberBetween(1, CategorySeeder::CATEGORIES),
                'product_id' => $i,
            ];
        }

        $this->table('category_product')->insert($pivot)->saveData();
    }

    public function getDependencies()
    {
        return [
            CategorySeeder::class,
        ];
    }
}
