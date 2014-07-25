<?php

namespace MyApplication\Admin;

abstract class Presenter extends \MyApplication\App\Presenter
{
    public function startup()
    {
        parent::startup();
        if (!$this->user->isLoggedIn()) {
            $this->redirect(':App:Sign:in');
        }
    }
}
