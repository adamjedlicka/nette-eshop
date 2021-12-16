<?php

namespace App\Model\Entities;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property Product[] $products m:belongsToMany
 * @property Attribute[] $attributes m:hasMany(#inversed)
 * @property Category|null $parent m:hasOne
 * @property Category[] $children m:belongsToMany(parent_id)
 *
 * @method replaceAllAttributes(array $attributes)
 */
class Category extends BaseEntity
{
    public function getCategoryTree()
    {
        $tree = [];

        $current = $this;

        while ($current = $current->parent) {
            array_unshift($tree, $current);
        }

        return $tree;
    }
}
