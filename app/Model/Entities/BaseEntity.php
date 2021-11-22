<?php

namespace App\Model\Entities;

use JsonSerializable;
use LeanMapper\Entity;

abstract class BaseEntity extends Entity implements JsonSerializable
{
    public function jsonSerialize()
    {
        return $this->getData();
    }
}
