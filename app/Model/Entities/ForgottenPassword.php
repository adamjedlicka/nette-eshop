<?php

namespace App\Model\Entities;

use Dibi\DateTime;
use LeanMapper\Entity;

/**
 * @property string $id
 * @property User $user m:hasOne
 * @property string $code
 * @property-read DateTime $created
 */
class ForgottenPassword extends Entity
{
}
