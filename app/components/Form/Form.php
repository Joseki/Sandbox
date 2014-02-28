<?php

namespace Joseki\Form;

use Kdyby\Replicator\Container as RContainer;
use Nextras\Forms\Controls\DatePicker;



class Form extends \Nette\Application\UI\Form
{
	/**
	 * Adds DatePicker to enable user-friendly GUI for picking date
	 * @param $name
	 * @param null $label
	 * @return DatePicker
	 */
	public function addDatePicker($name, $label = NULL)
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
	public function addDynamic($name, $factory, $createDefault = 0, $forceDefault = FALSE)
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
