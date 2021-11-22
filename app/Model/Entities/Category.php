<?php

namespace App\Model\Entities;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property Product[] $products m:hasMany
 */
class Category extends BaseEntity
{
}
