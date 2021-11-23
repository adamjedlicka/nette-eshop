<?php

namespace App\Model\Repositories;

use App\Model\Entities\Category;
use App\Model\Entities\Product;
use App\Model\Entities\Value;

class ProductRepository extends BaseRepository
{
    public function findBy($cond): Product
    {
        return parent::findBy($cond);
    }

    public function getByFilteredCategory(Category $category, $valueId = null)
    {
        if (!$valueId) {
            return $category->products;
        }

        $rows = $this->connection->select('product.*')->from('product')
            ->join('category_product')->on('category_product.product_id', '=', 'product.id')
            ->join('product_value')->on('product_value.product_id', '=', 'product.id')
            ->where('category_product.category_id', '=', $category->id)
            ->where('product_value.value_id', '=', $valueId)
            ->fetchAll();

        return $this->createEntities($rows);
    }
}
