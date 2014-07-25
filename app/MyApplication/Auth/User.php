<?php

namespace MyApplication\Auth;

use Joseki\LeanMapper\BaseEntity;
use LeanMapper\Filtering;
use Nette\Security\IIdentity;

/**
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $name
 * @property string $surname
 * @property-read string $fullName
 * @property string|NULL $email
 * @property Role[] $roles m:hasMany (role)
 */
class User extends BaseEntity implements IIdentity
{
    /**
     * Returns the ID of user.
     * @return mixed
     */
    function getId()
    {
        $data = $this->row->getData();
        return $data['id'];
    }



    /**
     * Returns a list of roles that the user is a member of.
     * @return array
     */
    function getRoles()
    {
        return $this->getValueByPropertyWithRelationship('roles');
    }



    public function getFullName()
    {
        return "{$this->name} {$this->surname}";
    }
}
