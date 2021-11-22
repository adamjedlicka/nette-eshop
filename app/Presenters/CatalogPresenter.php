<?php

namespace App\Presenters;

use App\Model\Repositories\ProductRepository;

final class CatalogPresenter extends BasePresenter
{
    private ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository,
    ) {
        $this->productRepository = $productRepository;
    }

    public function renderDefault()
    {
        $this->template->products = $this->productRepository->findAll();
    }

    public function renderShow($slug)
    {
        $this->template->product = $this->productRepository->findBy(['slug' => $slug]);
    }
}
