<?php

namespace App\StorefrontModule\Components\UserLoginForm;

use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nette\Forms\Controls\SubmitButton;
use Nette\SmartObject;
use Nextras\FormsRendering\Renderers\Bs5FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;

class UserLoginForm extends Form
{
    use SmartObject;

    public $onFinished = [];

    public $onCancel = [];

    public function __construct(IContainer $parent = null, string $name = null)
    {
        parent::__construct($parent, $name);
        $this->setRenderer(new Bs5FormRenderer(FormLayout::VERTICAL));
        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $this->addEmail('email', 'E-mail')
            ->setRequired('Enter valid email');

        $this->addPassword('password', 'Password')
            ->setRequired('Enter your password');

        $this->addSubmit('ok', 'Login')
            ->onClick[] = function (SubmitButton $button) {
            $this->onFinished();
        };

        $this->addSubmit('storno', 'Cancel')
            ->setValidationScope([])
            ->onClick[] = function (SubmitButton $button) {
            $this->onCancel();
        };
    }
}
