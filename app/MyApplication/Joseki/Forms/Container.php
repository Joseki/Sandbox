<?php

namespace Joseki\Form;

use Kdyby\Replicator\Container as RContainer;
use Joseki\Form\Controls\SubmitButton;
use Nextras\Forms\Controls\DatePicker;

class Container extends \Nette\Forms\Container
{

    /**
     * @param $name
     * @param null $caption
     * @return SubmitButton|\Nette\Forms\Controls\SubmitButton
     */
    public function addSubmit($name, $caption = null)
    {
        return $this[$name] = new SubmitButton($caption);
    }



    /**
     * Adds DatePicker to enable user-friendly GUI for picking date
     * @param $name
     * @param null $label
     * @return DatePicker
     */
    public function addDatePicker($name, $label = null)
    {
        return $this[$name] = new DatePicker($label);
    }



    /**
     * Adds replicable container
     * @param $name
     * @param $factory
     * @param int $createDefault
     * @param bool $forceDefault
     * @return Container
     */
    public function addDynamic($name, $factory, $createDefault = 0, $forceDefault = false)
    {
        $control = new RContainer($factory, $createDefault, $forceDefault);
        $control->currentGroup = $this->currentGroup;
        return $this[$name] = $control;
    }



    /**
     * @inheritdoc
     */
    public function addContainer($name)
    {
        $control = new Container;
        $control->currentGroup = $this->currentGroup;
        return $this[$name] = $control;
    }
} 
