<?php

namespace App\Model\Entities;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $excerpt
 * @property string $description
 * @property int $price
 * @property string $thumbnail
 * @property Category $category m:hasOne
 * @property Value[] $values m:hasMany
 *
 * @method replaceAllValues(array $values)
 */
class Product extends BaseEntity
{
    public function getGrouppedValues(): array
    {
        $values = [];

        foreach ($this->values as $value) {
            if (!isset($values[$value->attribute->name])) {
                $values[$value->attribute->name] = [];
            }

            $values[$value->attribute->name][] = $value->name;
        }

        return $values;
    }
}
