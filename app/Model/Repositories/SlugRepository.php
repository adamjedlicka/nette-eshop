<?php

namespace App\Model\Repositories;

use App\Model\Entities\Slug;

class SlugRepository extends BaseRepository
{
    public function find($value): Slug
    {
        return parent::findBy(['value' => $value]);
    }
}
