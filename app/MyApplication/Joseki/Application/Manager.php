<?php


namespace Joseki\Application;

use Nette\InvalidArgumentException;
use Nette\Utils\Strings;

class Manager
{

    private $version;

    private $name;



    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }



    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }



    function __construct($version, $name)
    {
        if (!Strings::match($version, '#^v\d+\.\d+\.\d+$#')) {
            throw new InvalidArgumentException("Expected version :'vX.Y.Y', but '$version' given.");
        }
        $this->version = $version;
        $this->name = $name;
    }
}
