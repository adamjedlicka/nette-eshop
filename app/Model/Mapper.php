<?php

namespace App\Model;

use LeanMapper\DefaultMapper;
use LeanMapper\Exception\InvalidStateException;
use LeanMapper\Row;

class Mapper extends DefaultMapper
{
    public function __construct(?string $defaultEntityNamespace = 'App\Model\Entities')
    {
        parent::__construct($defaultEntityNamespace);
    }

    public function getTable(string $entityClass): string
    {
        return self::toUnderScore($this->trimNamespace($entityClass));
    }

    public function getEntityClass(string $table, Row $row = null): string
    {
        return ($this->defaultEntityNamespace !== NULL ? $this->defaultEntityNamespace . '\\' : '')
            . ucfirst(self::toCamelCase($table)); // Název třídy začíná velkým písmenem
    }

    public function getColumn(string $entityClass, string $field): string
    {
        return self::toUnderScore($field);
    }

    public function getEntityField(string $table, string $column): string
    {
        return self::toCamelCase($column);
    }

    public function getTableByRepositoryClass(string $repositoryClass): string
    {
        $matches = array();
        if (preg_match('#([a-z0-9]+)repository$#i', $repositoryClass, $matches)) {
            return self::toUnderScore($matches[1]);
        }
        throw new InvalidStateException('Cannot determine table name.');
    }

    public static function toUnderScore(string $str): string
    {
        return lcfirst(preg_replace_callback('#(?<=.)([A-Z])#', function ($m) {
            return '_' . strtolower($m[1]);
        }, $str));
    }

    public static function toCamelCase(string $str): string
    {
        return preg_replace_callback('#_(.)#', function ($m) {
            return strtoupper($m[1]);
        }, $str);
    }
}
