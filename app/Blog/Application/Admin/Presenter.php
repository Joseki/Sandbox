<?php

namespace Blog\Application\Admin;

abstract class Presenter extends \Blog\Application\Presenter
{
    public function startup()
    {
        parent::startup();
        if (!$this->user->isLoggedIn()) {
            $this->redirect(':App:Sign:in');
        }
    }
}
