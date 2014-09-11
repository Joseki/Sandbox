<?php

namespace Blog\Auth;

use Blog\Auth\User as UserTable;
use Joseki\LeanMapper\NotFoundException;
use Nette;
use Nette\Utils\Strings;

class Authenticator extends Nette\Object implements Nette\Security\IAuthenticator
{
    /** @var UserRepository */
    private $userRepository;



    function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }



    /**
     * @param array $credentials
     * @return UserTable|Nette\Security\IIdentity
     * @throws \Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials)
    {
        list($username, $password) = $credentials;

        $query = $this->userRepository->createQuery();
        $query->where('@login', $username);

        try {
            $user = $this->userRepository->findOneBy($query);
        } catch (NotFoundException $e) {
            throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
        }

        if (!$user->isPasswordValid($password)) {
            throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
        }

        return $user;
    }

}










