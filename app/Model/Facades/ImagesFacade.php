<?php

namespace App\Model\Facades;

use Nette\Http\FileUpload;
use Nette\Utils\FileSystem;

class ImagesFacade
{
    private string $documentRoot;

    public function __construct()
    {
        $this->documentRoot = $_SERVER['DOCUMENT_ROOT'];
    }

    public function getPlaceholderImage(): string
    {
        return '/images/placeholder.png';
    }

    public function save(FileUpload $image)
    {
        $path = '/images/' . $image->getSanitizedName();

        $image->move($this->documentRoot . $path);

        return $path;
    }

    public function delete(string $path)
    {
        FileSystem::delete($this->documentRoot . $path);
    }
}
