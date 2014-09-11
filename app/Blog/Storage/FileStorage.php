<?php

namespace Blog\Storage;

use Nette\Utils\Strings;

abstract class FileStorage
{

    private $root;



    function __construct($root)
    {
        if (!Strings::endsWith($root, '/')) {
            $root .= '/';
        }
        $this->root = $root;
        @mkdir($this->root, null, true);
    }



    public function load($filename)
    {
        $path = $this->root . $filename;
        if (!file_exists($path) || empty($filename)) {
            throw new FileNotFoundException("File '$path' not found.");
        }
        return file_get_contents($path);
    }



    public function save($filename, $content)
    {
        $path = $this->root . $filename;
        file_put_contents($path, $content);
    }



    /**
     * @return string
     */
    public function getRoot()
    {
        return $this->root;
    }
} 
