<?php

namespace App\AdminModule\Presenters;

use Nette\Application\ForbiddenRequestException;
use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{
    protected function startup()
    {
        parent::startup();

        $action = !empty($this->request->parameters['action']) ? $this->request->parameters['action'] : '';

        if (!$this->user->isAllowed($this->request->presenterName, $action)) {
            if ($this->user->isLoggedIn()) {
                throw new ForbiddenRequestException();
            } else {
                $this->flashMessage('You need to be logged in', 'warning');

                $this->redirect(':Storefront:User:login', ['backlink' => $this->storeRequest()]);
            }
        }
    }
}
