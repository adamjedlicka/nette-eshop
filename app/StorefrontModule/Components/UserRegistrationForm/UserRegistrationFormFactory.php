<?php

namespace App\StorefrontModule\Components\UserRegistrationForm;

interface UserRegistrationFormFactory
{
    public function create(): UserRegistrationForm;
}
