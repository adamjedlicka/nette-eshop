<?php

namespace App\StorefrontModule\Components\PaginationControl;

use Nette\Application\UI\Control;
use Nette\Http\Request;
use Nette\Http\UrlScript;
use Nette\Utils\Paginator;

class PaginationControl extends Control
{
    const TEMPLATE = __DIR__ . '/templates/default.latte';

    private int $radius = 5;

    private Paginator $paginator;

    private UrlScript $url;

    public function __construct(Request $request)
    {
        $this->paginator = new Paginator();
        $this->url = $request->getUrl();
    }

    public function getCurrentPage(): int
    {
        return (int)$this->url->getQueryParameter('pagination-page') ?: 1;
    }

    public function getPaginator(): Paginator
    {
        return $this->paginator;
    }

    public function setRadius(int $radius)
    {
        $this->radius = $radius;
    }

    public function setItemsPerPage(int $itemsPerPage)
    {
        $this->paginator->setItemsPerPage($itemsPerPage);
    }

    public function render()
    {
        $this->template->setFile(self::TEMPLATE);

        $this->paginator->setPage($this->getCurrentPage());

        $this->template->paginator = $this->paginator;

        $this->template->render();
    }
}
