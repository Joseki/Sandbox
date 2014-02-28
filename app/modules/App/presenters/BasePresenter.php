<?php
namespace App;

use Nette\Application\InvalidPresenterException;
use Nette\Application\UI\Presenter;
use WebLoader\Nette\CssLoader;
use WebLoader\Nette\JavaScriptLoader;



/**
 * Base presenter for all application presenters.
 */
class BasePresenter extends Presenter
{
	/** @var \Nette\Application\Application @inject */
	public $appl;

	/** @var \WebLoader\LoaderFactory @inject */
	public $webLoader;

	/** @var  string */
	public $appName;



	protected function startup()
	{
		parent::startup();
		$this->setErrorPresenter();
	}



	protected function beforeRender()
	{
		parent::beforeRender();
		$this->template->appName = $this->appName;
	}



	protected function setErrorPresenter()
	{
		$errorPresenter = 'Error';
		$modules = explode(":", $this->name);
		unset($modules[count($modules) - 1]);
		while (count($modules) != 0) {
			$catched = FALSE;
			try {
				$errorPresenter = implode(":", $modules) . ':Error';
				$errorPresenterClass = $this->appl->getPresenterFactory()->getPresenterClass($errorPresenter);
			} catch (InvalidPresenterException $e) {
				$catched = TRUE;
			}
			if (!$catched) {
				break;
			}
			unset($modules[count($modules) - 1]);
		}
		$this->appl->errorPresenter = $errorPresenter;
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
}
