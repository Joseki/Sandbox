<?php

namespace App\AppModule;

use App\BasePresenter;
use Joseki\Form\Form;



class TemplatePresenter extends BasePresenter
{
	/**
	 * @return Form
	 */
	protected function createComponentShowcase()
	{
		$values = array('one', 'two', 'three');
		$form = new Form();
		$form->addText('x', 'Label');
		$form->addPassword('k', 'Label');
		$form->addTextArea('y', 'Label');
		$form->addSelect('a', 'Label', $values);
		$form->addCheckbox('d', 'Label');
		$form->addCheckboxList('f', 'Label', $values);
		$form->addRadioList('j', 'Label', $values);
		$form->addImage('g', 'Label');
		$form->addSubmit('h', 'Label');
		$form->addButton('s', 'Label');

		$form->addGroup('Group');
		$form->addText('q', 'Label');
		$form->addText('w', 'Label');

		return $form;
	}
}
