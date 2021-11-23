<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class DefaultSeeder extends AbstractSeed
{
    const ATTRIBUTES = 5;

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
        $this->table('category')
            ->insert([
                [
                    'name' => 'Jeans',
                ],
                [
                    'name' => 'Shirts',
                ],
            ])
            ->saveData();

        $this->table('product')
            ->insert([
                [
                    'name' => 'Blue jeans',
                    'price' => 25000,
                ],
                [
                    'name' => 'Brown jeans',
                    'price' => 30000,
                ],
                [
                    'name' => 'Blue shirt',
                    'price' => 15000,
                ],
                [
                    'name' => 'Black shirt',
                    'price' => 15000,
                ],
            ])->saveData();

        $this->table('slug')
            ->insert([
                [
                    'value' => 'jeans',
                    'category_id' => 1,
                ],
                [
                    'value' => 'shirts',
                    'category_id' => 2,
                ],
                [
                    'value' => 'blue-jeans',
                    'product_id' => 1,
                ],
                [
                    'value' => 'brown-jeans',
                    'product_id' => 2,
                ],
                [
                    'value' => 'blue-shirt',
                    'product_id' => 3,
                ],
                [
                    'value' => 'brown-shirt',
                    'product_id' => 4,
                ],
            ])
            ->saveData();

        $this->table('category_product')
            ->insert([
                [
                    'category_id' => 1,
                    'product_id' => 1,
                ],
                [
                    'category_id' => 1,
                    'product_id' => 2,
                ],
                [
                    'category_id' => 2,
                    'product_id' => 3,
                ],
                [
                    'category_id' => 2,
                    'product_id' => 4,
                ],
            ])
            ->saveData();

        $this->table('attribute')
            ->insert([
                [
                    'name' => 'Color',
                ],
                [
                    'name' => 'Cut',
                ],
            ])
            ->saveData();

        $this->table('attribute_category')
            ->insert([
                [
                    'attribute_id' => 1,
                    'category_id' => 1,
                ],
                [
                    'attribute_id' => 1,
                    'category_id' => 2,
                ],
                [
                    'attribute_id' => 2,
                    'category_id' => 2,
                ],
            ])
            ->saveData();

        $this->table('value')
            ->insert([
                [
                    'name' => 'Blue',
                    'attribute_id' => 1,
                ],
                [
                    'name' => 'Brown',
                    'attribute_id' => 1,
                ],
                [
                    'name' => 'U',
                    'attribute_id' => 2,
                ],
                [
                    'name' => 'V',
                    'attribute_id' => 2,
                ],
                [
                    'name' => 'Black',
                    'attribute_id' => 1,
                ]
            ])
            ->saveData();

        $this->table('product_value')
            ->insert([
                [
                    'product_id' => 1,
                    'value_id' => 1,
                ],
                [
                    'product_id' => 2,
                    'value_id' => 2,
                ],
                [
                    'product_id' => 3,
                    'value_id' => 1,
                ],
                [
                    'product_id' => 4,
                    'value_id' => 5,
                ],
                [
                    'product_id' => 3,
                    'value_id' => 3,
                ],
                [
                    'product_id' => 4,
                    'value_id' => 4,
                ],
            ])
            ->saveData();
    }
}
