<?php

namespace App\AdminModule\Components\CategoryEditForm;

interface CategoryEditFormFactory
{
    public function create(): CategoryEditForm;
}
