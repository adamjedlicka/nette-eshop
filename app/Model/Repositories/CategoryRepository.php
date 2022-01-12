<?php

namespace App\Model\Repositories;

use App\Model\Entities\Category;

class CategoryRepository extends BaseRepository
{
    public function findBy($cond): Category
    {
        return parent::findBy($cond);
    }

    public function searchBy(string $query): array
    {
        $query = $this->connection->select('*')->from('category')
            ->where('name', 'LIKE', '\'%' . $query . '%\'');

        return $this->createEntities($query->fetchAll());
    }
}
