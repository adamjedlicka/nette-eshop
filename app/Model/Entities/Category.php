<?php

namespace App\Model\Entities;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Slug $slug m:belongsToOne
 * @property Product[] $products m:hasMany(:category_product)
 */
class Category extends BaseEntity
{
}
