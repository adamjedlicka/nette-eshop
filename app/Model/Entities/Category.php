<?php

namespace App\Model\Entities;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Slug $slug m:belongsToOne
 */
class Category extends BaseEntity
{
}
