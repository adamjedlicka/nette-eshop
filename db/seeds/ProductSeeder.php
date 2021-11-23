<?php

use Bezhanov\Faker\ProviderCollectionHelper;
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
        ProviderCollectionHelper::addAllProvidersTo($faker);

        $products = [];

        for ($i = 1; $i <= self::PRODUCTS; $i++) {
            $products[] = [
                'name' => $faker->productName(),
                'description' => $faker->text(),
                'price' => $faker->randomNumber(6),
                'thumbnail' => $faker->avatar($faker->word(), '300x300', 'jpg'),
            ];
        }

        $this->table('product')
            ->insert($products)
            ->saveData();

        $slugs = [];

        for ($i = 1; $i <= self::PRODUCTS; $i++) {
            $slugs[] = [
                'value' => $faker->unique()->slug(3),
                'product_id' => $i,
            ];
        }

        $this->table('slug')
            ->insert($slugs)
            ->saveData();

        $pivot = [];

        for ($i = 1; $i <= self::PRODUCTS; $i++) {
            $pivot[] = [
                'product_id' => $i,
                'category_id' => $faker->numberBetween(1, CategorySeeder::CATEGORIES),
            ];
        }

        $this->table('category_product')
            ->insert($pivot)
            ->saveData();
    }

    public function getDependencies()
    {
        return [
            CategorySeeder::class,
        ];
    }
}
