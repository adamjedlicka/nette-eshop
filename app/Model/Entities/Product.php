<?php

namespace App\Model\Entities;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $price
 * @property string $currency
 * @property string $thumbnail
 * @property Category $category m:belongsTo
 */
class Product extends BaseEntity
{
}
