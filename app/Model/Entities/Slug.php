<?php

namespace App\Model\Entities;

/**
 * @property int $id
 * @property string $value
 * @property Product|null $product m:hasOne
 * @property Category|null $category m:hasOne
 */
class Slug extends BaseEntity
{
}
