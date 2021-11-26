<?php

namespace App\Model\Facades;

use App\Model\Entities\Slug;
use App\Model\Repositories\SlugRepository;

class SlugsFacade
{
    private SlugRepository $slugRepository;

    public function __construct(SlugRepository $slugRepository)
    {
        $this->slugRepository = $slugRepository;
    }

    public function getSlug(string $value): Slug
    {
        return $this->slugRepository->findBy(['value' => $value]);
    }

    public function saveSlug(Slug $slug): bool
    {
        return (bool)$this->slugRepository->persist($slug);
    }
}
