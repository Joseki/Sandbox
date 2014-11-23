<?php
namespace MyApplication\Application;

use WebLoader\Nette\CssLoader;
use WebLoader\Nette\JavaScriptLoader;

/**
 * @property \MyApplication\Security\User $user
 */
abstract class Presenter extends \Nette\Application\UI\Presenter
{

    /** @var \Nette\Application\Application @inject */
    public $appl;

    /** @var \WebLoader\Nette\LoaderFactory @inject */
    public $webLoader;

    /** @var \MyApplication\Navigation\Navigation\NavigationControlFactory @inject */
    public $navFactory;



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
