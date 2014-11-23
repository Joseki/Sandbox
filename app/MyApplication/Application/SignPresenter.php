<?php

namespace MyApplication\Application;

class SignPresenter extends Presenter
{
    /** @var \MyApplication\Auth\SignIn\SignInControlFactory @inject */
    public $signFormFactory;



    protected function startup()
    {
        parent::startup();
        if ($this->user->isLoggedIn() && $this->action != 'out') {
            $this->redirect(':Admin:Homepage:');
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
            $this->redirect(':Admin:Homepage:');
        };

        return $control;
    }

}
