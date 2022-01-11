<?php

namespace App\StorefrontModule\Presenters;

use App\Model\Facades\CmsPageFacade;

class CmsPagePresenter extends BasePresenter
{
    private CmsPageFacade $cmsPageFacade;

    public function renderView(string $slug)
    {
        $cmsPage = $this->cmsPageFacade->getCmsPageBySlug($slug);

        $this->template->cmsPage = $cmsPage;
    }

    public function injectCmsPageFacade(CmsPageFacade $cmsPageFacade)
    {
        $this->cmsPageFacade = $cmsPageFacade;
    }
}
