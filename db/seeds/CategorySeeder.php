<?php

use Bezhanov\Faker\ProviderCollectionHelper;
use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class CategorySeeder extends AbstractSeed
{
    const CATEGORIES = 5;

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

        $categories = [];

        for ($i = 1; $i <= self::CATEGORIES; $i++) {
            $categories[] = [
                'name' => $faker->unique()->department(1),
                'description' => $faker->text(),
            ];
        }

        $this->table('category')
            ->insert($categories)
            ->saveData();

        $slugs = [];

        for ($i = 1; $i <= self::CATEGORIES; $i++) {
            $slugs[] = [
                'value' => $faker->unique()->slug(3),
                'category_id' => $i,
            ];
        }

        $this->table('slug')
            ->insert($slugs)
            ->saveData();
    }
}
