<?php

namespace App\AdminModule\Presenters;

use Nette\Application\ForbiddenRequestException;
use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{
    protected function startup()
    {
        parent::startup();

        $presenterName = $this->request->presenterName;
        $action = !empty($this->request->parameters['action']) ? $this->request->parameters['action'] : '';

        if (!$this->user->isAllowed($presenterName, $action)) {
            if ($this->user->isLoggedIn()) {
                throw new ForbiddenRequestException();
            } else {
                $this->flashMessage('Pro zobrazení požadovaného obsahu se musíte přihlásit!', 'warning');

                $this->redirect(':Storefront:User:login', ['backlink' => $this->storeRequest()]);
            }
        }
    }
}
