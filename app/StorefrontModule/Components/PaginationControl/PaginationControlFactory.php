<?php

namespace App\StorefrontModule\Components\PaginationControl;

interface PaginationControlFactory
{
    public function create(): PaginationControl;
}
