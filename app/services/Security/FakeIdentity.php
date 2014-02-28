<?php

namespace Services\Security;

use Nette\Security\IIdentity;



class FakeIdentity implements IIdentity
{

	/** @var mixed */
	private $id;



	function __construct($id)
	{
		$this->id = $id;
	}



	/**
	 * Returns the ID of user.
	 * @return mixed
	 */
	function getId()
	{
		return $this->id;
	}



	/**
	 * @return array
	 */
	function getRoles()
	{
		return array();
	}
}
