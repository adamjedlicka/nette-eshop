<?php

namespace App\Model\Repositories;

class ForgottenPasswordRepository extends BaseRepository
{
    public function deleteOldForgottenPasswords()
    {
        $this->connection->nativeQuery('DELETE FROM `forgotten_password` WHERE created < (NOW() - INTERVAL 1 HOUR)');
    }
}
