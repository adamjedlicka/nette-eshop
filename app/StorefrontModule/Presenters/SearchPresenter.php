<?php

namespace App\StorefrontModule\Presenters;

use App\Model\Facades\ProductsFacade;

class SearchPresenter extends BasePresenter
{
    private ProductsFacade $productsFacade;

    public function renderSearch(string $query)
    {
        $products = array_map(fn ($product) => [
            'name' => $product->name,
            'url' => $this->link('Product:view', $product->slug),
        ], $this->productsFacade->findProducts($query));

        $this->sendJson($products);
    }

    public function injectProductsFacade(ProductsFacade $productsFacade)
    {
        $this->productsFacade = $productsFacade;
    }
}
