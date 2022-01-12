<?php

namespace App\Model\Facades;

use App\Model\Entities\Category;
use App\Model\Repositories\CategoryRepository;
use Exception;
use Tracy\Debugger;

class CategoriesFacade
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategory(int $id): Category
    {
        return $this->categoryRepository->find($id);
    }

    public function getCategoryBySlug(string $slug): Category
    {
        return $this->categoryRepository->findBy(['slug' => $slug]);
    }

    public function findCategories($params = null, int $offset = null, int $limit = null): array
    {
        if (is_string($params)) {
            return $this->categoryRepository->searchBy($params);
        } else {
            return $this->categoryRepository->findAllBy($params, $offset, $limit);
        }
    }

    public function findCategoriesCount(array $params = null): int
    {
        return $this->categoryRepository->findCountBy($params);
    }

    public function saveCategory(Category &$category): bool
    {
        return (bool)$this->categoryRepository->persist($category);
    }

    public function deleteCategory(Category $category): bool
    {
        try {
            return (bool)$this->categoryRepository->delete($category);
        } catch (Exception $e) {
            Debugger::log($e);
            return false;
        }
    }
}
