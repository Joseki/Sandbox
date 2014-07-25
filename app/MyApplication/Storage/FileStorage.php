<?php

namespace Services\Storage;

use Nette\Utils\Strings;

class FileStorage
{

    private $root;



    function __construct($root)
    {
        if (!Strings::endsWith($root, '/')) {
            $root .= '/';
        }
        $this->root = $root;
    }



    public function load($file)
    {
        return file_get_contents($this->root . $file);
    }
} 
