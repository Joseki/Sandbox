<?php

namespace Joseki\Form;

use Joseki\Form\Controls\SubmitButton;
use Nextras\Forms\Controls\DatePicker;



class Container extends \Nette\Forms\Container
{

	/**
	 * @param $name
	 * @param null $caption
	 * @return SubmitButton|\Nette\Forms\Controls\SubmitButton
	 */
	public function addSubmit($name, $caption = NULL)
	{
		return $this[$name] = new SubmitButton($caption);
	}



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
} 
