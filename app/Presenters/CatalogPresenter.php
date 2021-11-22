<?php

namespace App\Presenters;

use App\Model\Repositories\CategoryRepository;
use App\Model\Repositories\ProductRepository;
use App\Model\Repositories\SlugRepository;
use Exception;

final class CatalogPresenter extends BasePresenter
{
    private SlugRepository $slugRepository;

    private ProductRepository $productRepository;

    private CategoryRepository $categoryRepository;

    public function __construct(
        SlugRepository $slugRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
    ) {
        $this->slugRepository = $slugRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function renderDefault()
    {
        $this->template->products = $this->productRepository->findAll();
    }

    public function renderShow($slug)
    {
        $slug = $this->slugRepository->find($slug);

        if ($slug->product) {
            $this->template->product = $slug->product;
            $this->template->setFile(__DIR__ . '/templates/Catalog/_product.latte');
            return;
        } else if ($slug->category) {
            $this->template->category = $slug->category;
            $this->template->setFile(__DIR__ . '/templates/Catalog/_category.latte');
            return;
        }
    }
}
