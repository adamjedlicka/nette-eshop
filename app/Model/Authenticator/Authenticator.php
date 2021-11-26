<?php

namespace App\Model\Authenticator;

use App\Model\Facades\UsersFacade;
use Nette\Security\AuthenticationException;
use Nette\Security\Authenticator as SecurityAuthenticator;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;

class Authenticator implements SecurityAuthenticator
{
    private Passwords $passwords;

    private UsersFacade $usersFacade;

    public function __construct(
        Passwords $passwords,
        UsersFacade $usersFacade,
    ) {
        $this->passwords = $passwords;
        $this->usersFacade = $usersFacade;
    }

    function authenticate(string $email, string $password): IIdentity
    {
        try {
            $user = $this->usersFacade->getUserByEmail($email);
        } catch (\Exception $e) {
            throw new AuthenticationException('User not found');
        }

        if ($this->passwords->verify($password, $user->password)) {
            return $this->usersFacade->getUserIdentity($user);
        } else {
            throw new AuthenticationException('Incorrect email or password');
        }
    }
}
