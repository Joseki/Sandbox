<?php

namespace Blog\Application;

class SignPresenter extends Presenter
{
    /** @var \Blog\Auth\SignFormFactory @inject */
    public $signFormFactory;



    protected function startup()
    {
        parent::startup();
        if ($this->user->isLoggedIn() && $this->action != 'out') {
            $this->redirect(':App:Homepage:');
        }
    }



    public function actionOut()
    {
        $this->user->logout(true);
        $this->redirect('in');
    }



    protected function createComponentSignForm()
    {
        $control = $this->signFormFactory->create();
        $control->onSuccess[] = function () {
            $this->redirect(':App:Homepage:');
        };

        return $control;
    }

}
