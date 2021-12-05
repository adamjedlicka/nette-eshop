<?php

namespace App\Model\Entities;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property Product[] $products m:belongsToMany
 * @property Attribute[] $attributes m:hasMany(#inversed)
 *
 * @method replaceAllAttributes(array $attributes)
 */
class Category extends BaseEntity
{
}
