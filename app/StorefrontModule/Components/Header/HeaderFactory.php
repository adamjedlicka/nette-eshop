<?php

namespace App\StorefrontModule\Components\Header;

use App\Model\Repositories\CategoryRepository;
use App\StorefrontModule\Components\CartControl\CartControlFactory;

class HeaderFactory
{
    private CategoryRepository $categoryRepository;

    private CartControlFactory $cartControlFactory;

    public function __construct(
        CategoryRepository $categoryRepository,
        CartControlFactory $cartControlFactory,
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->cartControlFactory = $cartControlFactory;
    }

    public function create(): Header
    {
        $categories = $this->categoryRepository->findAll();

        return new Header($categories, $this->cartControlFactory);
    }
}
