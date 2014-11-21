<?php

namespace MyApplication\Security;

use Nette\Security\IAuthorizator;

class User extends \Nette\Security\User
{

    /**
     * Returns current user identity, if any.
     * @return \MyApplication\Auth\User|NULL
     */
    public function getIdentity()
    {
        return parent::getIdentity();
    }



    /**
     * Has a user effective access to the Resource?
     * If $resource is NULL, then the query applies to all resources.
     * @param  string  resource
     * @param  string  privilege
     * @return bool
     */
    public function isAllowed($resource = IAuthorizator::ALL, $privilege = IAuthorizator::ALL)
    {
        if ($this->getAuthorizator()->isAllowed($this->getIdentity(), $resource, $privilege)) {
            return true;
        }

        return false;
    }
}
