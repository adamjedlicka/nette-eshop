<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\CmsPageEditForm\CmsPageEditForm;
use App\AdminModule\Components\CmsPageEditForm\CmsPageEditFormFactory;
use App\Model\Facades\CmsPageFacade;
use Exception;
use Tracy\Debugger;

class CmsPagePresenter extends BasePresenter
{
    private CmsPageFacade $cmsPageFacade;

    private CmsPageEditFormFactory $cmsPageEditFormFactory;

    public function renderDefault()
    {
        $this->template->cmsPages = $this->cmsPageFacade->findCmsPages();
    }

    public function actionEdit(int $id)
    {
        try {
            $cmsPage = $this->cmsPageFacade->getCmsPage($id);
        } catch (Exception $e) {
            Debugger::log($e);
            $this->flashMessage('CMS page not found', 'error');
            $this->redirect('default');
        }

        if (!$this->user->isAllowed($cmsPage, 'edit')) {
            $this->flashMessage('This CMS page cannot be edited', 'error');
            $this->redirect('default');
        }

        $form = $this->getCmsPageEditForm();
        $form->setDefaults($cmsPage);

        $this->template->cmsPage = $cmsPage;
    }

    public function actionDelete(int $id)
    {
        try {
            $cmsPage = $this->cmsPageFacade->getCmsPage($id);
        } catch (Exception $e) {
            Debugger::log($e);
            $this->flashMessage('CMS page not found', 'error');
            $this->redirect('default');
        }

        if (!$this->user->isAllowed($cmsPage, 'delete')) {
            $this->flashMessage('This CMS page cant be deleted', 'error');
            $this->redirect('default');
        }

        if ($this->cmsPageFacade->deleteCmsPage($cmsPage)) {
            $this->flashMessage('CMS page was deleted', 'info');
        } else {
            $this->flashMessage('This CMS page cant be deleted', 'error');
        }

        $this->redirect('default');
    }

    public function createComponentCmsPageEditForm(): CmsPageEditForm
    {
        $form = $this->cmsPageEditFormFactory->create();

        $form->onSuccess[] = function () {
            $this->redirect('default');
        };

        return $form;
    }

    public function getCmsPageEditForm(): CmsPageEditForm
    {
        return $this->getComponent('cmsPageEditForm');
    }

    public function injectCmsPageFacade(CmsPageFacade $cmsPageFacade)
    {
        $this->cmsPageFacade = $cmsPageFacade;
    }

    public function injectCmsPageFormFactory(CmsPageEditFormFactory $cmsPageEditFormFactory)
    {
        $this->cmsPageEditFormFactory = $cmsPageEditFormFactory;
    }
}
