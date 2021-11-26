<?php

namespace App\Model\Authorizator;

class AuthenticatedRole implements \Nette\Security\Role
{
    public int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    function getRoleId(): string
    {
        return 'authenticated';
    }
}
