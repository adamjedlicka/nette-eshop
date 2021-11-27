<?php

namespace App\AdminModule\Components\ProductEditForm;

interface ProductEditFormFactory
{
    public function create(): ProductEditForm;
}
