<?php

namespace App\AdminModule\Components\AttributeEditForm;

interface AttributeEditFormFactory
{
    public function create(): AttributeEditForm;
}
