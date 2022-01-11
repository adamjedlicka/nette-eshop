<?php

namespace App\Model\Entities;


/**
 * @property int $id
 * @property User|null $user m:hasOne
 * @property \DateTimeImmutable $createdAt
 * @property \DateTimeImmutable|null $paidAt
 * @property string $serializedContent
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $street
 * @property string $city
 * @property string $zip
 * @property string $country
 */
class Order extends BaseEntity
{

}
