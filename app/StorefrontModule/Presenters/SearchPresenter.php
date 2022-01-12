<?php

namespace App\StorefrontModule\Presenters;

use App\Model\Entities\Category;
use App\Model\Entities\Product;
use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\ProductsFacade;

class SearchPresenter extends BasePresenter
{
    private ProductsFacade $productsFacade;

    private CategoriesFacade $categoriesFacade;

    public function renderSearch(string $query)
    {
        $products = array_map(fn (Product $product) => [
            'name' => $product->name,
            'url' => $this->link('Product:view', $product->slug),
        ], $this->productsFacade->findProducts($query));

        $categories = array_map(fn (Category $category) => [
            'name' => $category->name,
            'url' => $this->link('Category:view', $category->slug),
        ], $this->categoriesFacade->findCategories($query));

        $results = array_merge($products, $categories);

        usort($results, fn ($a, $b) => strcmp($a['name'], $b['name']));

        $this->sendJson($results);
    }

    public function injectProductsFacade(ProductsFacade $productsFacade)
    {
        $this->productsFacade = $productsFacade;
    }

    public function injectCategoriesFacade(CategoriesFacade $categoriesFacade)
    {
        $this->categoriesFacade = $categoriesFacade;
    }
}
