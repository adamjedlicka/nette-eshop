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
        $categoryIds = $this->getCategoryIds([$category->id]);

        $query = $this->connection->select('product.*')->from('product')
            ->leftJoin('product_value')->on('product_value.product_id', '=', 'product.id')
            ->where('product.category_id', 'IN', '(' . implode(', ', $categoryIds) . ')');

        if ($values) {
            $query->where('product_value.value_id', 'IN', '(' . implode(', ', $values) . ')');
        }

        return $this->createEntities($query->fetchAll());
    }

    private function getCategoryIds(array $parentIds, bool $root = true): array
    {
        $results = $this->connection->select('category.id')->from('category')
            ->where('category.parent_id', 'IN', '(' . implode(', ', $parentIds) . ')')
            ->fetchAll();

        $ids = array_map(fn ($row) => $row->id, $results);

        if ($root) {
            array_unshift($ids, $parentIds[0]);
        }

        if (count($ids) > 0) {
            return array_merge($ids, $this->getCategoryIds($ids, false));
        } else {
            return $ids;
        }
    }
}
