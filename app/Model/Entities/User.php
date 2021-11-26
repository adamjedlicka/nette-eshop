<?php

namespace App\Model\Entities;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $password = null
 * @property Role|null $role m:hasOne
 */
class User extends BaseEntity
{
}
