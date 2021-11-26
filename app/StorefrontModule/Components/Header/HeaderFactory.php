<?php

namespace App\StorefrontModule\Components\Header;

use App\Model\Repositories\CategoryRepository;

class HeaderFactory
{
    private CategoryRepository $categoryRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(): Header
    {
        $categories = $this->categoryRepository->findAll();

        return new Header($categories);
    }
}
