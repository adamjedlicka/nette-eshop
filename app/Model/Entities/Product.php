<?php

namespace App\Model\Entities;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property string $currency
 * @property string $slug
 * @property Category[] $categories m:hasMany(product_id:category_product:category_id:category)
 */
class Product extends BaseEntity
{
}
