<?php

namespace App\Model\Facades;

use App\Model\Entities\Value;
use App\Model\Repositories\ValueRepository;
use Exception;
use Tracy\Debugger;

class ValuesFacade
{
    private ValueRepository $valueRepository;

    public function __construct(
        ValueRepository $valueRepository,
    ) {
        $this->valueRepository = $valueRepository;
    }

    public function getValue(int $id): Value
    {
        return $this->valueRepository->find($id);
    }

    public function saveValue(Value $value): bool
    {
        return (bool)$this->valueRepository->persist($value);
    }

    /**
     * @return Value[]
     */
    public function findValues($attribute = null): array
    {
        if ($attribute) {
            return $this->valueRepository->findAllBy(['attribute_id' => $attribute]);
        } else {
            return $this->valueRepository->findAll();
        }
    }

    public function deleteValue(Value $value): bool
    {
        try {
            return (bool)$this->valueRepository->delete($value);
        } catch (Exception $e) {
            Debugger::log($e);
            return false;
        }
    }
}
