<?php

namespace App\StorefrontModule\Components\Navigation;

use App\Model\Repositories\CategoryRepository;
use App\StorefrontModule\Components\CartControl\CartControlFactory;
use Nette\Application\LinkGenerator;
use Nette\Routing\Router;

class NavigationFactory
{
    private CategoryRepository $categoryRepository;
    private LinkGenerator $linkGenerator;

    public function __construct(
        CategoryRepository $categoryRepository,
        LinkGenerator $linkGenerator
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->linkGenerator = $linkGenerator;
    }

    public function create(): Navigation
    {
        $categories = $this->categoryRepository->findAll();

        return new Navigation($categories, $this->linkGenerator);
    }
}
