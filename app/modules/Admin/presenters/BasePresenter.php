<?php

namespace App\AdminModule;

use App\BasePresenter as Presenter;



/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Presenter
{
	public function startup()
	{
		parent::startup();
		if (!$this->user->isLoggedIn()) {
			$this->redirect('Sign:in');
		}
	}
}
