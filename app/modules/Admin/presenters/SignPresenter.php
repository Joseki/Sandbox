<?php

namespace App\AdminModule;

use App\BasePresenter as Presenter;
use Joseki\Form\Form;
use Nette\Security\AuthenticationException;



/**
 * Sign in/out presenters.
 */
class SignPresenter extends Presenter
{

	/**
	 * Sign-in form factory.
	 *
	 * @return Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new Form();
		$form->getElementPrototype()->addAttributes(array('class' => 'login'));
		$form->addText('username', 'Username:')->setRequired('Please enter your username.');

		$form->addPassword('password', 'Password:')->setRequired('Please enter your password.');

		$form->addCheckbox('remember', 'Keep me signed in');

		$form->addSubmit('send', 'Sign in');

		// call method signInFormSucceeded() on success
		$form->onSuccess[] = $this->signInFormSucceeded;

		return $form;
	}



	public function signInFormSucceeded(Form $form)
	{
		$values = $form->getValues();

		if ($values->remember) {
			$this->getUser()->setExpiration('14 days', FALSE);
		} else {
			$this->getUser()->setExpiration('30 minutes', TRUE);
		}

		try {
			$this->getUser()->login($values->username, $values->password);
			$this->redirect('Homepage:');
		} catch (AuthenticationException $e) {
			$this->flashMessage($e->getMessage());
		}
	}



	public function actionOut()
	{
		$this->getUser()->logout(TRUE);
		$this->flashMessage('You have been signed out.');
		$this->redirect('in');
	}

}
