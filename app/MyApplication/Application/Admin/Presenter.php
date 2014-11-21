<?php

namespace MyApplication\Application\Admin;

abstract class Presenter extends \MyApplication\Application\Presenter
{
    public function checkRequirements()
    {
        if (!$this->user->isLoggedIn()) {
            $this->redirect(':Sign:in');
        }
    }
}
