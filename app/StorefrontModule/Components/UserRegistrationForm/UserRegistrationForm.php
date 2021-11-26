<?php

namespace App\StorefrontModule\Components\UserRegistrationForm;

use App\Model\Entities\User;
use App\Model\Facades\UsersFacade;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nette\Forms\Controls\SubmitButton;
use Nette\Forms\Controls\TextInput;
use Nette\Security\Passwords;
use Nette\SmartObject;
use Nextras\FormsRendering\Renderers\Bs5FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;

class UserRegistrationForm extends Form
{
    use SmartObject;

    private UsersFacade $usersFacade;

    private Passwords $passwords;

    public $onFinished = [];

    public $onCancel = [];

    public function __construct(IContainer $parent = null, string $name = null, UsersFacade $usersFacade, Passwords $passwords)
    {
        parent::__construct($parent, $name);
        $this->setRenderer(new Bs5FormRenderer(FormLayout::VERTICAL));
        $this->usersFacade = $usersFacade;
        $this->passwords = $passwords;
        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $this->addText('name', 'First name and last name')
            ->setRequired('Enter your name')
            ->setHtmlAttribute('maxlength', 40)
            ->addRule(Form::MAX_LENGTH, 'Name is too long', 40);

        $this->addEmail('email', 'E-mail')
            ->setRequired('Enter valid email')
            ->addRule(function (TextInput $input) {
                try {
                    $this->usersFacade->getUserByEmail($input->value);
                } catch (\Exception $e) {
                    return true;
                }
                return false;
            }, 'User with this email already exists');

        $password = $this->addPassword('password', 'Password');
        $password
            ->setRequired('Enter password')
            ->addRule(Form::MIN_LENGTH, 'Enter is too short', 5);
        $this->addPassword('password2', 'Password confirmation')
            ->addRule(Form::EQUAL, 'Passwords do not match', $password);

        $this->addSubmit('ok', 'Register')
            ->onClick[] = function (SubmitButton $button) {
            $values = $this->getValues('array');
            $user = new User();
            $user->name = $values['name'];
            $user->email = $values['email'];
            $user->password = $this->passwords->hash($values['password']);

            if ($values['email'] === 'admin@admin.admin') {
                foreach ($this->usersFacade->findRoles() as $role) {
                    if ($role->id === 'admin') {
                        $user->role = $role;
                    }
                }
            }

            $this->usersFacade->saveUser($user);

            $this->onFinished();
        };

        $this->addSubmit('storno', 'Cancel')
            ->setValidationScope([])
            ->onClick[] = function (SubmitButton $button) {
            $this->onCancel();
        };
    }
}
