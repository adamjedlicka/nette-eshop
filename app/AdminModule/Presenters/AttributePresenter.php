<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\AttributeEditForm\AttributeEditForm;
use App\AdminModule\Components\AttributeEditForm\AttributeEditFormFactory;
use App\Model\Facades\AttributesFacade;
use Exception;
use Tracy\Debugger;

class AttributePresenter extends BasePresenter
{
    private AttributesFacade $attributesFacade;

    private AttributeEditFormFactory $attributeEditFormFactory;

    public function renderDefault()
    {
        $this->template->attributes = $this->attributesFacade->findAttributes();
    }

    public function actionDelete(int $id)
    {
        try {
            $attribute = $this->attributesFacade->getAttribute($id);
        } catch (Exception $e) {
            Debugger::log($e);
            $this->flashMessage('Attribute not found', 'error');
            $this->redirect('default');
        }

        if (!$this->user->isAllowed($attribute, 'delete')) {
            $this->flashMessage('This attribute cant be deleted', 'error');
            $this->redirect('default');
        }

        if ($this->attributesFacade->deleteAttribute($attribute)) {
            $this->flashMessage('Attribute was deleted', 'info');
        } else {
            $this->flashMessage('This attribute cant be deleted', 'error');
        }

        $this->redirect('default');
    }

    public function actionEdit(int $id)
    {
        try {
            $attribute = $this->attributesFacade->getAttribute($id);
        } catch (Exception $e) {
            Debugger::log($e);
            $this->flashMessage('Attribute not found', 'error');
            $this->redirect('default');
        }

        if (!$this->user->isAllowed($attribute, 'edit')) {
            $this->flashMessage('This attribute cannot be edited', 'error');
            $this->redirect('default');
        }

        $form = $this->getAttributeEditForm();
        $form->setDefaults($attribute);

        $this->template->attribute = $attribute;
    }

    public function createComponentAttributeEditForm(): AttributeEditForm
    {
        $form = $this->attributeEditFormFactory->create();

        $form->onSuccess[] = function () {
            $this->redirect('default');
        };

        return $form;
    }

    private function getAttributeEditForm(): AttributeEditForm
    {
        return $this->getComponent('attributeEditForm');
    }

    public function injectAttributesFacade(AttributesFacade $attributesFacade)
    {
        $this->attributesFacade = $attributesFacade;
    }

    public function injectAttributeEditFormFactory(AttributeEditFormFactory $attributeEditFormFactory)
    {
        $this->attributeEditFormFactory = $attributeEditFormFactory;
    }
}
