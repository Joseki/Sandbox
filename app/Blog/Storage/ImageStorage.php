<?php

namespace Blog\Storage;

use Nette\Utils\Image;

class ImageStorage extends FileStorage
{

    /**
     * @param string $filename
     * @return Image
     */
    public function load($filename)
    {
        $content = parent::load($filename); // check if file exists
        return Image::fromFile($this->getRoot() . $filename);
    }
} 
