<?php

namespace MyApplication\Storage;

use Nette\Utils\Strings;

class FileStorage
{

    private $root;



    function __construct($root)
    {
        if (!Strings::endsWith($root, '/')) {
            $root .= '/';
        }
        if (!is_dir($root)) {
            throw new FileNotFoundException("Root directory '$root' not found.");
        }
        $this->root = $root;
    }



    public function load($file)
    {
        $this->check($file);
        return file_get_contents($this->getPathTo($file));
    }



    public function save($file, $content)
    {
        $path = $this->getPathTo($file);
        @mkdir(dirname($path));
        file_put_contents($path, $content);
    }



    public function check($file)
    {
        $path = $this->getPathTo($file);
        if (!file_exists($path)) {
            throw new FileNotFoundException("File '$path' not found.");
        }
    }



    public function getPathTo($file)
    {
        return $this->root . $file;
    }
} 
