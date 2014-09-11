<?php


namespace Blog\Storage;

use Nette\Http\FileUpload;
use Nette\Utils\Image;
use Tracy\Debugger;

class ImageCacheStorage extends FileStorage
{

    /**
     * @param FileUpload|Image $image
     * @param string $filename
     * @param $format
     * @return mixed
     */
    public function save($image, $filename, $format = null)
    {
        $filename = $format . $filename;
        if ($image instanceof Image) {
            $image->save($this->getRoot() . $filename);
        } else {
            $content = $image->getContents();
            file_put_contents($this->getRoot() . $filename, $content);
        }
    }



    /**
     * @param string $filename
     * @param $format
     * @return Image
     */
    public function load($filename, $format = null)
    {
        $filename = $format . $filename;
        parent::load($filename); // check if file exists
        return Image::fromFile($this->getRoot() . $filename);
    }



    public function hash($name, $format = null)
    {
        return md5($name . $format);
    }
}
