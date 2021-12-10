<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\ValueEditForm\ValueEditForm;
use App\AdminModule\Components\ValueEditForm\ValueEditFormFactory;
use App\Model\Facades\ValuesFacade;
use Exception;
use Tracy\Debugger;

class ValuePresenter extends BasePresenter
{
    private ValuesFacade $valuesFacade;

    private ValueEditFormFactory $valueEditFormFactory;

    public function renderDefault()
    {
        $this->template->values = $this->valuesFacade->findValues();
    }

    public function actionDelete(int $id)
    {
        try {
            $value = $this->valuesFacade->getValue($id);
        } catch (Exception $e) {
            Debugger::log($e);
            $this->flashMessage('Value not found', 'error');
            $this->redirect('default');
        }

        if (!$this->user->isAllowed($value, 'delete')) {
            $this->flashMessage('This value cant be deleted', 'error');
            $this->redirect('default');
        }

        if ($this->valuesFacade->deleteValue($value)) {
            $this->flashMessage('Value was deleted', 'info');
        } else {
            $this->flashMessage('This value cant be deleted', 'error');
        }

        $this->redirect('default');
    }

    public function actionEdit(int $id)
    {
        try {
            $value = $this->valuesFacade->getValue($id);
        } catch (Exception $e) {
            Debugger::log($e);
            $this->flashMessage('Value not found', 'error');
            $this->redirect('default');
        }

        if (!$this->user->isAllowed($value, 'edit')) {
            $this->flashMessage('This value cannot be edited', 'error');
            $this->redirect('default');
        }

        $form = $this->getValueEditForm();
        $form->setDefaults($value);

        $this->template->value = $value;
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
