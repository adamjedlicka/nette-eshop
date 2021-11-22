<?php

namespace App\Model\Repositories;

use App\Model\Entities\Category;

class CategoryRepository extends BaseRepository
{
    public function findBy($cond): Category
    {
        return parent::findBy($cond);
    }
}
