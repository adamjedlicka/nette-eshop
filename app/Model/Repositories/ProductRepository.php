<?php

namespace App\Model\Repositories;

use App\Model\Entities\Product;

class ProductRepository extends BaseRepository
{
    public function findBy($cond): Product
    {
        return parent::findBy($cond);
    }
}
