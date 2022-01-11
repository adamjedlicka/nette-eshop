<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\ValueEditForm\ValueEditForm;
use App\AdminModule\Components\ValueEditForm\ValueEditFormFactory;
use App\AdminModule\Components\ValuesFilterForm\ValuesFilterForm;
use App\AdminModule\Components\ValuesFilterForm\ValuesFilterFormFactory;
use App\Model\Facades\AttributesFacade;
use App\Model\Facades\ValuesFacade;
use Exception;
use Tracy\Debugger;

class ValuePresenter extends BasePresenter
{
    private ValuesFacade $valuesFacade;

    private AttributesFacade $attributesFacade;

    private ValueEditFormFactory $valueEditFormFactory;

    private ValuesFilterFormFactory $valuesFilterFormFactory;

    public function renderDefault($attribute = null)
    {
        $this->template->values = $this->valuesFacade->findValues($attribute);
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

    public function createComponentValuesFilterForm(): ValuesFilterForm
    {
        $form = $this->valuesFilterFormFactory->create();

        $form->selectedAttribute = $this->getParameter('attribute');

        $form->onSuccess[] = function ($filters) {
            $this->redirect('default', $filters['attribute']);
        };

        $form->createSubcomponents();

        return $form;
    }

    private function getValueEditForm(): ValueEditForm
    {
        return $this->getComponent('valueEditForm');
    }

    private function getValuesFilterForm(): ValuesFilterForm
    {
        return $this->getComponent('valuesFilterForm');
    }

    public function injectValuesFacade(ValuesFacade $valuesFacade)
    {
        $this->valuesFacade = $valuesFacade;
    }

    public function injectAttributesFacade(AttributesFacade $attributesFacade)
    {
        $this->attributesFacade = $attributesFacade;
    }

    public function injectValueEditFormFactory(ValueEditFormFactory $valueEditFormFactory)
    {
        $this->valueEditFormFactory = $valueEditFormFactory;
    }

    public function injectValuesFilterFormFactory(ValuesFilterFormFactory $valuesFilterFormFactory)
    {
        $this->valuesFilterFormFactory = $valuesFilterFormFactory;
    }
}
