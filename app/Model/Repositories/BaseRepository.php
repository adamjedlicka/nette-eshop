<?php

namespace App\Model\Repositories;

use LeanMapper\Repository;
use App\Exceptions\EntityNotFoundException;

class BaseRepository extends Repository
{
    public function findBy($cond)
    {
        $row = $this->connection->select('*')
            ->from($this->getTable())
            ->where($cond)
            ->fetch();

        if ($row === null) {
            throw new EntityNotFoundException('Entity was not found.');
        }

        return $this->createEntity($row);
    }

    public function find($id)
    {
        return $this->findBy(['id' => $id]);
    }

    public function findAll()
    {
        $rows = $this->connection->select('*')
            ->from($this->getTable())
            ->fetchAll();

        return $this->createEntities($rows);
    }

    public function findAllBy($whereArr = null, $offset = null, $limit = null)
    {
        $query = $this->connection->select('*')->from($this->getTable());

        if (isset($whereArr['order'])) {
            $query->orderBy($whereArr['order']);
            unset($whereArr['order']);
        }

        if ($whereArr != null && count($whereArr) > 0) {
            $query = $query->where($whereArr);
        }

        return $this->createEntities($query->fetchAll($offset, $limit));
    }

    public function findCountBy($whereArr = null)
    {
        $query = $this->connection->select('count(*) as pocet')->from($this->getTable());

        if ($whereArr != null) {
            $query = $query->where($whereArr);
        }

        return $query->fetchSingle();
    }
}
