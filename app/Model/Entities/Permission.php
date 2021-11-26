<?php

namespace App\Model\Entities;

use LeanMapper\Entity;

/**
 * @property int $id
 * @property string $action
 * @property string $type = 'allow' m:Enum(self::TYPE_*)
 * @property string $roleId
 * @property string $resourceId
 * @property-read Role $role m:hasOne
 * @property-read Resource $resource m:hasOne
 */
class Permission extends Entity
{
    const TYPE_ALLOW = 'allow';
    const TYPE_DENY = 'deny';
}
