<?php

namespace App\Model\Repositories;

use LeanMapper\Repository;
use App\Exceptions\EntityNotFoundException;

class BaseRepository extends Repository
{
    public function find($id)
    {
        $row = $this->connection->select('*')
            ->from($this->getTable())
            ->where($this->mapper->getPrimaryKey($this->getTable()) . '= %i', $id)
            ->fetch();

        if ($row === null) {
            throw new EntityNotFoundException('Entity was not found.');
        }

        return $this->createEntity($row);
    }

    public function findAll()
    {
        $rows = $this->connection->select('*')
            ->from($this->getTable())
            ->fetchAll();

        return $this->createEntities($rows);
    }
}
