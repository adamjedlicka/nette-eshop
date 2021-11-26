<?php

namespace App\StorefrontModule\Components\UserLoginForm;

interface UserLoginFormFactory
{
    public function create(): UserLoginForm;
}
