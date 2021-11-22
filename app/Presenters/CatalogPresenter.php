<?php

namespace App\Presenters;

use App\Model\Repositories\CategoryRepository;
use App\Model\Repositories\ProductRepository;
use Exception;

final class CatalogPresenter extends BasePresenter
{
    private ProductRepository $productRepository;

    private CategoryRepository $categoryRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function renderDefault()
    {
        $this->template->products = $this->productRepository->findAll();
    }

    public function renderShow($slug)
    {
        try {
            $this->template->product = $this->productRepository->findBy(['slug' => $slug]);
            $this->template->setFile(__DIR__ . '/templates/Catalog/_product.latte');
            return;
        } catch (Exception $e) {
            // Dp nothing
        }

        $this->template->category = $this->categoryRepository->findBy(['slug' => $slug]);
        $this->template->setFile(__DIR__ . '/templates/Catalog/_category.latte');
    }
}
