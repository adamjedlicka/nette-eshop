<?php

namespace App\Model\Entities;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Slug $slug m:belongsToOne
 * @property Product[] $products m:hasMany(:category_product)
 * @property Attribute[] $attributes m:hasMany(:attribute_category)
 */
class Category extends BaseEntity
{
}
