<?php

namespace App\StorefrontModule\Presenters;

use App\Model\Facades\UsersFacade;
use App\StorefrontModule\Components\UserLoginForm\UserLoginForm;
use App\StorefrontModule\Components\UserLoginForm\UserLoginFormFactory;
use App\StorefrontModule\Components\UserRegistrationForm\UserRegistrationForm;
use App\StorefrontModule\Components\UserRegistrationForm\UserRegistrationFormFactory;
use Exception;
use Nette\Application\Attributes\Persistent;
use Tracy\Debugger;

class UserPresenter extends BasePresenter
{
    private UsersFacade $usersFacade;

    private UserLoginFormFactory $userLoginFormFactory;

    private UserRegistrationFormFactory $userRegistrationFormFactory;

    #[Persistent]
    public $backlink = '';

    public function actionLogout()
    {
        if ($this->user->isLoggedIn()) {
            $this->user->logout();
        }
        $this->redirect('Homepage:default');
    }

    protected function createComponentUserLoginForm(): UserLoginForm
    {
        $form = $this->userLoginFormFactory->create();
        $form->onFinished[] = function () use ($form) {
            $values = $form->getValues('array');
            try {
                $this->user->login($values['email'], $values['password']);
                $this->usersFacade->deleteForgottenPasswordsByUser($this->user->id);
            } catch (Exception $e) {
                Debugger::log($e);
                $this->flashMessage('Incorrect email or password!', 'error');
                $this->redirect('login');
            }

            $this->restoreRequest($this->backlink);
            $this->redirect('Homepage:default');
        };

        $form->onCancel[] = function () use ($form) {
            $this->redirect('Homepage:default');
        };

        return $form;
    }

    protected function createComponentUserRegistrationForm(): UserRegistrationForm
    {
        $form = $this->userRegistrationFormFactory->create();
        $form->onFinished[] = function () use ($form) {
            $values = $form->getValues('array');
            try {
                $this->user->login($values['email'], $values['password']);
                $this->flashMessage('Welcome');
            } catch (\Exception $e) {
                Debugger::log($e);
                $this->flashMessage('There was an error during during login', 'error');
            }
            $this->redirect('Homepage:default');
        };
        $form->onCancel[] = function () use ($form) {
            $this->redirect('Homepage:default');
        };
        return $form;
    }

    public function injectUsersFacade(UsersFacade $usersFacade)
    {
        $this->usersFacade = $usersFacade;
    }

    public function injectUserLoginFormFactory(UserLoginFormFactory $userLoginFormFactory)
    {
        $this->userLoginFormFactory = $userLoginFormFactory;
    }

    public function injectUserRegistrationFormFactory(UserRegistrationFormFactory $userRegistrationFormFactory)
    {
        $this->userRegistrationFormFactory = $userRegistrationFormFactory;
    }
}
