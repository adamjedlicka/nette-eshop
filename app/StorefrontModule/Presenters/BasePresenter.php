<?php

namespace App\StorefrontModule\Presenters;

use App\StorefrontModule\Components\Header\Header;
use App\StorefrontModule\Components\Header\HeaderFactory;
use Nette\Application\UI\Presenter;
use Tracy\Debugger;

class BasePresenter extends Presenter
{
    private HeaderFactory $headerFactory;

    public function beforeRender()
    {
        parent::beforeRender();

        $this->redrawControl('title');
        $this->redrawControl('content');
    }

    protected function createComponentHeader(): Header
    {
        return $this->headerFactory->create();
    }

    public function injectHeaderFactory(HeaderFactory $headerFactory)
    {
        $this->headerFactory = $headerFactory;
    }
}
