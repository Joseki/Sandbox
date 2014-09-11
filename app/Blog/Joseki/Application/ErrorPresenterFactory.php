<?php


namespace Joseki\Application;

use Nette\Application\InvalidPresenterException;
use Nette\Application\IPresenterFactory;
use Nette\Application\IRouter;
use Nette\Application\Request;
use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\Http\IRequest;

class ErrorPresenterFactory
{

    const ROUTER_CACHE_KEY = 'errorPresenterFactory';

    /** @var \Nette\Application\IRouter */
    private $router;

    /** @var \Nette\Http\IRequest */
    private $httpRequest;

    /** @var \Nette\Application\IPresenterFactory */
    private $presenterFactory;

    /** @var Cache */
    private $cache;

    private $defaultErrorPresenter = null;

    private $version;



    function __construct(IPresenterFactory $presenterFactory, IRouter $router, IRequest $httpRequest, IStorage $storage)
    {
        $this->router = $router;
        $this->httpRequest = $httpRequest;
        $this->presenterFactory = $presenterFactory;
        $this->cache = new Cache($storage, self::ROUTER_CACHE_KEY);
    }



    /**
     * @return null|string
     */
    public function getErrorPresenter()
    {
        $key = md5($this->httpRequest->getUrl() . $this->version);
        if ($errorPresenter = $this->cache->load($key) === null) {
            $request = $this->router->match($this->httpRequest);

            if (!$request instanceof Request) {
                return $this->defaultErrorPresenter;
            }

            $errorPresenter = $this->defaultErrorPresenter;
            $name = $request->getPresenterName();
            $modules = explode(":", $name);
            unset($modules[count($modules) - 1]);
            while (count($modules) != 0) {
                $catched = false;
                try {
                    $errorPresenter = implode(":", $modules) . ':Error';
                    $this->presenterFactory->getPresenterClass($errorPresenter);
                    break;
                } catch (InvalidPresenterException $e) {
                    $catched = true;
                }
                unset($modules[count($modules) - 1]);
            }
            if (isset($catched) && $catched) {
                return $this->defaultErrorPresenter;
            }

            $this->cache->save($key, $errorPresenter, array('version' => $this->version));
        }

        return $errorPresenter;
    }



    /**
     * @param null $defaultErrorPresenter
     */
    public function setDefaultErrorPresenter($defaultErrorPresenter)
    {
        $this->defaultErrorPresenter = $defaultErrorPresenter;
    }



    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }
}
