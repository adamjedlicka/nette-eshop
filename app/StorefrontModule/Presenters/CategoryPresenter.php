<?php

namespace App\StorefrontModule\Presenters;

use App\Model\Facades\CategoriesFacade;

class CategoryPresenter extends BasePresenter
{
    private CategoriesFacade $categoriesFacade;

    public function renderView($slug)
    {
        $this->template->category = $this->categoriesFacade->getCategoryBySlug($slug);
    }

    public function injectCategoriesFacade(CategoriesFacade $categoriesFacade)
    {
        $this->categoriesFacade = $categoriesFacade;
    }
}
