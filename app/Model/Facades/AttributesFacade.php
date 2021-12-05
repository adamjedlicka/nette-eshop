<?php

namespace App\Model\Facades;

use App\Model\Entities\Attribute;
use App\Model\Repositories\AttributeRepository;
use Exception;
use Tracy\Debugger;

class AttributesFacade
{
    private AttributeRepository $attributeRepository;

    public function __construct(
        AttributeRepository $attributeRepository,
    ) {
        $this->attributeRepository = $attributeRepository;
    }

    public function getAttribute(int $id): Attribute
    {
        return $this->attributeRepository->find($id);
    }

    public function saveAttribute(Attribute $attribute): bool
    {
        return (bool)$this->attributeRepository->persist($attribute);
    }

    public function findAttributes(): array
    {
        return $this->attributeRepository->findAll();
    }

    public function deleteAttribute(Attribute $attribute): bool
    {
        try {
            return (bool)$this->attributeRepository->delete($attribute);
        } catch (Exception $e) {
            Debugger::log($e);
            return false;
        }
    }
}
