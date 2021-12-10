<?php

namespace App\StorefrontModule\Presenters;

use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\ProductsFacade;
use App\StorefrontModule\Components\FiltersControl\FiltersControl;
use App\StorefrontModule\Components\FiltersControl\FiltersControlFactory;

class CategoryPresenter extends BasePresenter
{
    private CategoriesFacade $categoriesFacade;

    private ProductsFacade $productsFacade;

    private FiltersControlFactory $filtersControlFactory;

    public function actionView($slug, $values)
    {
        $category = $this->categoriesFacade->getCategoryBySlug($slug);
        $products = $this->productsFacade->getCategoryProducts($category, json_decode($values));

        $this->getFilters()->createSubcomponents($category, json_decode($values));

        $this->getFilters()->onSuccess[] = function ($values) use ($slug) {
            $this->redirect('view', $slug, json_encode($values));
        };

        $this->template->category = $category;
        $this->template->products = $products;
    }

    protected function createComponentFilters(): FiltersControl
    {
        return $this->filtersControlFactory->create();
    }

    private function getFilters(): FiltersControl
    {
        return $this->getComponent('filters');
    }

    public function injectCategoriesFacade(CategoriesFacade $categoriesFacade)
    {
        $this->categoriesFacade = $categoriesFacade;
    }

    public function injectProductsFacade(ProductsFacade $productsFacade)
    {
        $this->productsFacade = $productsFacade;
    }

    public function injectFiltersControlFactory(FiltersControlFactory $filtersControlFactory)
    {
        $this->filtersControlFactory = $filtersControlFactory;
    }
}
