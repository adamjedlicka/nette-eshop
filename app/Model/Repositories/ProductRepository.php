<?php

namespace App\Model\Repositories;

use App\Model\Entities\Product;

class ProductRepository extends BaseRepository
{
    public function find($id): Product
    {
        return parent::find($id);
    }
}
