<?php
namespace Blog\Application;

use Joseki\Application\Manager;
use Nette\Application\InvalidPresenterException;
use WebLoader\Nette\CssLoader;
use WebLoader\Nette\JavaScriptLoader;

/**
 * @property \Blog\Security\User $user
 */
abstract class Presenter extends \Nette\Application\UI\Presenter
{
    /** @var \Nette\Application\Application @inject */
    public $appl;

    /** @var \WebLoader\LoaderFactory @inject */
    public $webLoader;

    /** @var \Blog\Navigation\NavigationFactory @inject */
    public $navFactory;

    /** @var \Nette\Caching\IStorage @inject */
    public $storage;

    /** @var  Manager @inject */
    public $applicationManager;



    protected function startup()
    {
        parent::startup();
    }



    protected function beforeRender()
    {
        parent::beforeRender();
        $this->template->appName = $this->applicationManager->getName();
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
        $list = array(
            "$dir/$presenter/@$layout.latte",
        );
        do {
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
            "$dir/$presenter/$this->view.latte",
        );
    }



    /** @return CssLoader */
    protected function createComponentCss()
    {
        return $this->webLoader->createCssLoader('default');
    }



    /** @return CssLoader */
    protected function createComponentCssLibs()
    {
        return $this->webLoader->createCssLoader('libs');
    }



    /** @return CssLoader */
    protected function createComponentCssTexyla()
    {
        return $this->webLoader->createCssLoader('texyla');
    }



    /** @return JavaScriptLoader */
    protected function createComponentJs()
    {
        return $this->webLoader->createJavaScriptLoader('default');
    }



    /** @return JavaScriptLoader */
    protected function createComponentJsLibs()
    {
        return $this->webLoader->createJavaScriptLoader('libs');
    }



    /** @return JavaScriptLoader */
    protected function createComponentJsTexyla()
    {
        return $this->webLoader->createJavaScriptLoader('texyla');
    }



    protected function createComponentNav()
    {
        return $this->navFactory->create();
    }
}
