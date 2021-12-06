<?php

namespace App\Model\Repositories;

use App\Model\Entities\Category;
use App\Model\Entities\Product;

class ProductRepository extends BaseRepository
{
    public function findBy($cond): Product
    {
        return parent::findBy($cond);
    }

    public function getByFilteredCategory(Category $category, $values = null)
    {
        if (!$values) {
            return $category->products;
        }

        $rows = $this->connection->select('product.*')->from('product')
            ->join('product_value')->on('product_value.product_id', '=', 'product.id')
            ->where('product.category_id', '=', $category->id)
            ->where('product_value.value_id', 'IN', '(' . implode(', ', $values) . ')')
            ->fetchAll();

        return $this->createEntities($rows);
    }
}
