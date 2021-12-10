<?php

namespace App\StorefrontModule\Components\FiltersControl;

interface FiltersControlFactory
{
    public function create(): FiltersControl;
}
