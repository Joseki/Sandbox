<?php


namespace Blog\Storage;

use Blog\Auth\User;
use Blog\Auth\UserRepository;
use Nette\Http\Session;
use Nette;
use Nette\Http\UserStorage as NetteHttpUserStorage;
use Nette\Security\IIdentity;
use Blog\Security\FakeIdentity;

class UserStorage extends NetteHttpUserStorage
{

    /** @var UserRepository */
    private $userRepository;

    private $identity;



    public function  __construct(Session $sessionHandler, UserRepository $userRepository)
    {
        parent::__construct($sessionHandler);
        $this->userRepository = $userRepository;
    }



    /**
     * Sets the user identity.
     * @param \Nette\Security\IIdentity $identity
     * @return UserStorage Provides a fluent interface
     */
    public function setIdentity(IIdentity $identity = null)
    {
        if ($identity !== null) {
            $identity = new FakeIdentity($identity->getId());
        }

        return parent::setIdentity($identity);
    }



    /**
     * Returns current user identity, if any.
     * @return User|NULL
     */
    public function getIdentity()
    {
        if ($this->identity) {
            return $this->identity;
        }
        $identity = parent::getIdentity();
        if ($identity instanceof FakeIdentity) {
            $this->identity = $this->userRepository->get($identity->getId());
            return $this->identity;
        }

        return $identity;
    }

}
