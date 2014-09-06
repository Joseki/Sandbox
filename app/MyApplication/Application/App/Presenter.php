<?php
namespace MyApplication\App;

use Joseki\Application\Manager;
use Nette\Application\InvalidPresenterException;
use WebLoader\Nette\CssLoader;
use WebLoader\Nette\JavaScriptLoader;

/**
 * @property \MyApplication\Security\User $user
 */
abstract class Presenter extends \Nette\Application\UI\Presenter
{
    /** @var \Nette\Application\Application @inject */
    public $appl;

    /** @var \WebLoader\LoaderFactory @inject */
    public $webLoader;

    /** @var \MyApplication\Navigation\NavigationFactory @inject */
    public $navFactory;

    /** @var \Nette\Caching\IStorage @inject */
    public $storage;

    /** @var  Manager @inject */
    public $applicationManager;



    protected function startup()
    {
        parent::startup();
        $this->setErrorPresenter();
    }



    protected function beforeRender()
    {
        parent::beforeRender();
        $this->template->appName = $this->applicationManager->getName();
    }



    protected function setErrorPresenter()
    {
        $errorPresenter = 'Error';
        $modules = explode(":", $this->name);
        unset($modules[count($modules) - 1]);
        while (count($modules) != 0) {
            $catched = false;
            try {
                $errorPresenter = implode(":", $modules) . ':Error';
                $errorPresenterClass = $this->appl->getPresenterFactory()->getPresenterClass($errorPresenter);
            } catch (InvalidPresenterException $e) {
                $catched = true;
            }
            if (!$catched) {
                break;
            }
            unset($modules[count($modules) - 1]);
        }
        if (isset($catched) && $catched) {
            $errorPresenter = 'App:Error';
        }
        $this->appl->errorPresenter = $errorPresenter;
    }



    /**
     * Formats layout template file names.
     * @return array
     */
    public function formatLayoutTemplateFiles()
    {
        $name = $this->getName();
        $presenter = substr($name, strrpos(':' . $name, ':'));
        $layout = $this->layout ? $this->layout : 'layout';
        $dir = dirname($this->getReflection()->getFileName());
//        $dir = is_dir("$dir/templates") ? $dir : dirname($dir);
        $list = array(
            "$dir/templates/$presenter/@$layout.latte",
            "$dir/templates/$presenter.@$layout.latte",
            "$dir/$presenter/@$layout.latte",
            "$dir/$presenter.@$layout.latte",
        );
        do {
            $list[] = "$dir/templates/@$layout.latte";
            $list[] = "$dir/@$layout.latte";
            $dir = dirname($dir);
        } while ($dir && ($name = substr($name, 0, strrpos($name, ':'))));
        return $list;
    }



    /**
     * Formats view template file names.
     * @return array
     */
    public function formatTemplateFiles()
    {
        $name = $this->getName();
        $presenter = substr($name, strrpos(':' . $name, ':'));
        $dir = dirname($this->getReflection()->getFileName());
        return array(
            "$dir/templates/$presenter/$this->view.latte",
            "$dir/templates/$presenter.$this->view.latte",
            "$dir/$presenter/$this->view.latte",
            "$dir/$presenter.$this->view.latte",
        );
    }



    /** @return CssLoader */
    protected function createComponentCss()
    {
        return $this->webLoader->createCssLoader('default');
    }



    /** @return JavaScriptLoader */
    protected function createComponentJs()
    {
        return $this->webLoader->createJavaScriptLoader('default');
    }



    protected function createComponentNav()
    {
        return $this->navFactory->create();
    }
}
