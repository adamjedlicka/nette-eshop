<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class CategorySeeder extends AbstractSeed
{
    const CATEGORIES = 10;

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

        for ($i = 0; $i < self::CATEGORIES; $i++) {
            $data[] = [
                'name' => $faker->name(),
                'description' => $faker->text(),
            ];
        }

        $this->table('category')->insert($data)->saveData();

        $slugs = [];

        for ($i = 1; $i <= self::CATEGORIES; $i++) {
            $slugs[] = [
                'value' => $faker->unique()->slug(),
                'category_id' => $i,
            ];
        }

        $this->table('slug')->insert($slugs)->saveData();
    }
}
