<?php

namespace App\Security;

use App\Entity\Users;
use App\Exception\AccountDeletedException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof Users) {
            return;
        }

        if (!$user->getvalidated()) {
            throw new CustomUserMessageAuthenticationException(
                "Account not activated ! Please check your email !"
            );
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof Users) {
            return;
        }
    }
}
