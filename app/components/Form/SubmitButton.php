<?php

namespace Joseki\Form\Controls;

use Kdyby\Replicator\Container;



class SubmitButton extends \Nette\Forms\Controls\SubmitButton
{
	public function addRemoveOnClick($callback = NULL)
	{
		$replicator = $this->lookup(__NAMESPACE__ . '\Container');
		$this->setValidationScope(FALSE);
		$this->onClick[] = function (SubmitButton $button) use ($replicator, $callback) {
			/** @var Container $replicator */
			if (is_callable($callback)) {
				callback($callback)->invoke($replicator, $button->parent);
			}
			if ($form = $button->getForm(FALSE)) {
				$form->onSuccess = array();
			}
			$replicator->remove($button->parent);
		};
		return $this;
	}



	public function addCreateOnClick($allowEmpty = FALSE, $callback = NULL)
	{
		$replicator = $this->lookup(__NAMESPACE__ . '\Container');
		$this->onClick[] = function (SubmitButton $button) use ($replicator, $allowEmpty, $callback) {
			/** @var Container $replicator */
			if (!is_bool($allowEmpty)) {
				$callback = callback($allowEmpty);
				$allowEmpty = FALSE;
			}
			if ($allowEmpty === FALSE && $replicator->isAllFilled() === FALSE) {
				return;
			}
			$newContainer = $replicator->createOne();
			if (is_callable($callback)) {
				callback($callback)->invoke($replicator, $newContainer);
			}
			$button->getForm()->onSuccess = array();
		};
		return $this;
	}
} 
