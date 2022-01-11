<?php

namespace App\Model\Facades;

use App\Model\Entities\CmsPage;
use App\Model\Repositories\CmsPageRepository;
use Exception;
use Tracy\Debugger;

class CmsPageFacade
{
    private CmsPageRepository $cmsPageRepository;

    public function __construct(
        CmsPageRepository $cmsPageRepository,
    ) {
        $this->cmsPageRepository = $cmsPageRepository;
    }

    public function getCmsPage(int $id): CmsPage
    {
        return $this->cmsPageRepository->find($id);
    }

    public function getCmsPageBySlug(string $slug): CmsPage
    {
        return $this->cmsPageRepository->findBy(['slug' => $slug]);
    }

    public function saveCmsPage(CmsPage $cmsPage): bool
    {
        return (bool)$this->cmsPageRepository->persist($cmsPage);
    }

    /**
     * @return CmsPage[]
     */
    public function findCmsPages(): array
    {
        return $this->cmsPageRepository->findAll();
    }

    public function deleteCmsPage(CmsPage $cmsPage): bool
    {
        try {
            return (bool)$this->cmsPageRepository->delete($cmsPage);
        } catch (Exception $e) {
            Debugger::log($e);
            return false;
        }
    }
}
