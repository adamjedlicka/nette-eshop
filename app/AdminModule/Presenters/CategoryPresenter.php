<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\CategoryEditForm\CategoryEditForm;
use App\AdminModule\Components\CategoryEditForm\CategoryEditFormFactory;
use App\Model\Facades\CategoriesFacade;

class CategoryPresenter extends BasePresenter
{
    private CategoriesFacade $categoriesFacade;

    private CategoryEditFormFactory $categoryEditFormFactory;

    public function renderDefault(): void
    {
        $this->template->categories = $this->categoriesFacade->findCategories(['order' => 'name']);
    }

    public function renderEdit(int $id): void
    {
        try {
            $category = $this->categoriesFacade->getCategory($id);
        } catch (\Exception $e) {
            $this->flashMessage('Category not found', 'error');
            $this->redirect('default');
            return;
        }

        $form = $this->getCategoryEditForm();
        $form->setDefaults($category);
        $this->template->category = $category;
    }

    public function actionDelete(int $id): void
    {
        try {
            $category = $this->categoriesFacade->getCategory($id);
        } catch (\Exception $e) {
            $this->flashMessage('Category not found', 'error');
            $this->redirect('default');
            return;
        }

        if (!$this->user->isAllowed($category, 'delete')) {
            $this->flashMessage('This category cant be deleted', 'error');
            $this->redirect('default');
            return;
        }

        if ($this->categoriesFacade->deleteCategory($category)) {
            $this->flashMessage('Category was deleted', 'info');
        } else {
            $this->flashMessage('This category cant be deleted', 'error');
        }

        $this->redirect('default');
    }

    /**
     * Formulář na editaci kategorií
     * @return CategoryEditForm
     */
    public function createComponentCategoryEditForm(): CategoryEditForm
    {
        $form = $this->categoryEditFormFactory->create();
        $form->onCancel[] = function () {
            $this->redirect('default');
        };
        $form->onFinished[] = function ($message = null) {
            if (!empty($message)) {
                $this->flashMessage($message);
            }
            $this->redirect('default');
        };
        $form->onFailed[] = function ($message = null) {
            if (!empty($message)) {
                $this->flashMessage($message, 'error');
            }
            $this->redirect('default');
        };
        return $form;
    }

    private function getCategoryEditForm(): CategoryEditForm
    {
        return $this->getComponent('categoryEditForm');
    }

    public function injectCategoriesFacade(CategoriesFacade $categoriesFacade)
    {
        $this->categoriesFacade = $categoriesFacade;
    }

    public function injectCategoryEditFormFactory(CategoryEditFormFactory $categoryEditFormFactory)
    {
        $this->categoryEditFormFactory = $categoryEditFormFactory;
    }
}
