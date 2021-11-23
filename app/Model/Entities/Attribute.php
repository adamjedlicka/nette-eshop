<?php

namespace App\Model\Entities;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Value[] $values m:belongsToMany
 */
class Attribute extends BaseEntity
{
}
