<?php

namespace App\Model\Entities;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property string $currency
 * @property Slug $slug m:belongsToOne(product_id:slug)
 * @property Category[] $categories m:hasMany(:category_product)
 */
class Product extends BaseEntity
{
}
