<?php

namespace App\StorefrontModule\Components\Navigation;

use App\Model\Entities\Category;
use Nette\Application\LinkGenerator;
use Nette\Application\UI\Control;

class Navigation extends Control
{
    private $categories;
    private LinkGenerator $linkGenerator;

    public function __construct($categories, LinkGenerator $linkGenerator)
    {
        $this->categories = $categories;
        $this->linkGenerator = $linkGenerator;
    }

    public function render(): void
    {
        $nav = [];

        foreach ($this->categories as $category) {
            if ($category->parent === null) {
                $nav[] = $this->getChildTree($category);
            }
        }

        $this->template->rootCategoryNav = $nav;
        $this->template->render(__DIR__ . '/navigation.latte');
    }

    private function getChildTree(Category $category)
    {
        $itemText = $category->name;

        if (count($category->children) > 0) {
            $itemText .= ' &#8628;';
        }

        $itemLink = $this->linkGenerator->link('Storefront:Category:view', ['slug' => $category->slug]);
        $itemHtml = '<a class="ajax dropdown-item" href="' . $itemLink . '">' . $itemText . '  </a>';

        $childNodes = [];

        foreach ($category->children as $child) {
            $childNodes[] = $this->getChildTree($child);
        }

        if (count($childNodes) > 0) {
            $itemHtml = $itemHtml . '<ul class="submenu dropdown-menu">' . implode('', $childNodes) . '</ul>';
        }

        return '<li class="">' . $itemHtml . '</li>';
    }

}
