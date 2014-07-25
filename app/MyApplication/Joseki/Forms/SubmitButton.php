<?php

namespace Joseki\Form\Controls;

use Kdyby\Replicator\Container;

class SubmitButton extends \Nette\Forms\Controls\SubmitButton
{
    public function addRemoveOnClick($callback = null)
    {
        /** @var Container $replicator */
        $replicator = $this->lookup(__NAMESPACE__ . '\Container');
        $this->setValidationScope(false);
        $this->onClick[] = function (SubmitButton $button) use ($replicator, $callback) {
            if (is_callable($callback)) {
                callback($callback)->invoke($replicator, $button->parent);
            }
            if ($form = $button->getForm(false)) {
                $form->onSuccess = array();
            }
            $replicator->remove($button->parent);
        };
        return $this;
    }



    public function addCreateOnClick($allowEmpty = false, $callback = null)
    {
        /** @var Container $replicator */
        $replicator = $this->lookup(__NAMESPACE__ . '\Container');
        $this->onClick[] = function (SubmitButton $button) use ($replicator, $allowEmpty, $callback) {
            if (!is_bool($allowEmpty)) {
                $callback = callback($allowEmpty);
                $allowEmpty = false;
            }
            if ($allowEmpty === false && $replicator->isAllFilled() === false) {
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
