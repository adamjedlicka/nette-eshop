<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\ValueEditForm\ValueEditForm;
use App\AdminModule\Components\ValueEditForm\ValueEditFormFactory;
use App\Model\Facades\ValuesFacade;

class ValuePresenter extends BasePresenter
{
    private ValuesFacade $valuesFacade;

    private ValueEditFormFactory $valueEditFormFactory;

    public function renderDefault()
    {
        $this->template->values = $this->valuesFacade->findValues();
    }

    public function createComponentValueEditForm(): ValueEditForm
    {
        $form = $this->valueEditFormFactory->create();

        $form->onSuccess[] = function () {
            $this->redirect('default');
        };

        return $form;
    }

    private function getValueEditForm(): ValueEditForm
    {
        return $this->getComponent('valueEditForm');
    }

    public function injectValuesFacade(ValuesFacade $valuesFacade)
    {
        $this->valuesFacade = $valuesFacade;
    }

    public function injectValueEditFormFactory(ValueEditFormFactory $valueEditFormFactory)
    {
        $this->valueEditFormFactory = $valueEditFormFactory;
    }
}
