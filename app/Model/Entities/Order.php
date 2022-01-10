<?php

namespace App\Model\Entities;

use Dibi\DateTime;

/**
 * @property int $id
 * @property User $user
 * @property DateTime $createdAt
 * @property ?DateTime $paidAt
 * @property string $serializedContent
 */
class Order extends BaseEntity
{

}
