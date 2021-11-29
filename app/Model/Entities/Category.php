<?php

namespace App\Model\Entities;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property Product[] $products m:belongsToMany
 */
class Category extends BaseEntity
{
}
