<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;

class BasePresenter extends Presenter
{
    public function beforeRender()
    {
        parent::beforeRender();

        $this->redrawControl('title');
        $this->redrawControl('content');
    }
}
