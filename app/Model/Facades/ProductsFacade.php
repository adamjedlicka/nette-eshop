<?php

namespace App\Model\Facades;

use App\Model\Entities\Category;
use App\Model\Entities\Product;
use App\Model\Repositories\ProductRepository;
use Exception;
use Tracy\Debugger;

class ProductsFacade
{
    private ProductRepository $productRepository;

    private ImagesFacade $imagesFacade;

    public function __construct(
        ProductRepository $productRepository,
        ImagesFacade $imagesFacade,
    ) {
        $this->productRepository = $productRepository;
        $this->imagesFacade = $imagesFacade;
    }

    public function getProduct(int $id): Product
    {
        return $this->productRepository->find($id);
    }

    public function getProductBySlug(string $slug): Product
    {
        return $this->productRepository->findBy(['slug' => $slug]);
    }

    public function findProducts(array $params = null, int $offset = null, int $limit = null): array
    {
        return $this->productRepository->findAllBy($params, $offset, $limit);
    }

    public function saveProduct(Product $product): bool
    {
        return (bool)$this->productRepository->persist($product);
    }

    public function deleteProduct(Product $product): bool
    {
        try {
            $ok = (bool)$this->productRepository->delete($product);

            if ($ok) {
                $this->imagesFacade->delete($product->thumbnail);
            }

            return $ok;
        } catch (Exception $e) {
            Debugger::log($e);
            return false;
        }
    }

    public function getCategoryProducts(Category $category, $values): array
    {
        return $this->productRepository->getByFilteredCategory($category, $values);
    }
}
