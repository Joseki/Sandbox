<?php

namespace Blog\Application;

use Blog\Storage\FileNotFoundException;
use Blog\Storage\ImageStorage;
use Blog\Storage\ImageCacheStorage;
use Nette\Utils\Image;

class ImagePresenter extends Presenter
{

    /** @var ImageStorage */
    public $storage;

    /** @var ImageCacheStorage */
    public $imageCacheStorage;

    const DEFAULT_IMAGE = 'preview.png';



    public function actionDefault($name, $format = '600x400')
    {
        if (empty($name)) {
            $name = self::DEFAULT_IMAGE;
        }
        list($width, $height) = explode("x", $format);

        // prevents from storing same images with invalid format multiple times
        $fakeImage = Image::fromBlank(1024, 768);
        $fakeImage->resize($width, $height, Image::SHRINK_ONLY);
        $format = $fakeImage->width . 'x' . $fakeImage->height;
        $name = urldecode($name);

        try {
            $image = $this->imageCacheStorage->load($name, $format);
        } catch (FileNotFoundException $e) {
            try {
                $content = $this->storage->load($name); // check if file exists
            } catch (FileNotFoundException $e) {
                $name = 'preview.png';
                $content = $this->storage->load($name);
            }
            $image = Image::fromString($content);

            $image->resize($width, $height);
            $this->imageCacheStorage->save($image, $name, $format);
        }

        $image->send();
        $this->terminate();
    }



    /**
     * @param \CentrumArael\Storage\ImageStorage $storage
     */
    public function setStorage(ImageStorage $storage)
    {
        $this->storage = $storage;
    }



    /**
     * @param \CentrumArael\Storage\ImageCacheStorage $imageCacheStorage
     */
    public function setImageCacheStorage(ImageCacheStorage $imageCacheStorage)
    {
        $this->imageCacheStorage = $imageCacheStorage;
    }
}
