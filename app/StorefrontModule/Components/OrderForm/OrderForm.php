<?php

namespace App\StorefrontModule\Components\OrderForm;

use App\Model\Entities\Cart;
use App\Model\Entities\Product;
use App\Model\Facades\CartsFacade;
use App\Model\Facades\OrdersFacade;
use App\StorefrontModule\Components\CartControl\CartControl;
use App\StorefrontModule\Components\CartControl\CartControlFacade;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nette\Forms\Controls\SubmitButton;
use Nette\Forms\Controls\TextInput;
use Nette\Security\User;
use Nette\SmartObject;
use Nextras\FormsRendering\Renderers\Bs5FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;

class OrderForm extends Form
{
    use SmartObject;

    public $onFinished = [];

    public $onSubmit = [];

    public $onCancel = [];
    private OrdersFacade $ordersFacade;
    private CartsFacade $cartsFacade;

    public function __construct(
        IContainer $parent = null,
        string $name = null,
        OrdersFacade $ordersFacade,
        CartsFacade $cartsFacade
    )
    {
        parent::__construct($parent, $name);
        $this->setRenderer(new Bs5FormRenderer(FormLayout::VERTICAL));
        $this->createSubcomponents();
        $this->ordersFacade = $ordersFacade;
        $this->cartsFacade = $cartsFacade;
    }

    public function createSubcomponents()
    {
        $this->addHidden('cartId', null)->setRequired(true);
        $this->addText('name', 'Name')->setRequired(true);
        $this->addEmail('email', 'Email')->setRequired(true);
        $this->addText('phone', 'Phone number')->setRequired(true)->addRule($this->phoneValidator(), 'phone must include czech prefix, eg +420111222333');;
        $this->addText('street', 'Street and number')->setRequired(true);
        $this->addText('city', 'City')->setRequired(true);
        $this->addText('zip', 'Zip')->setRequired(true)->addRule($this->zipValidator(), 'zip must be five continuous numbers, eg 12045');
        $this->addText('country', 'Country')->setRequired(true);

        $this->addSubmit('send', 'Send order')
            ->onClick[] = function (SubmitButton $button) {

            $values = $this->getValues();
            $cart = $this->cartsFacade->getCartById($values['cartId']);

            $this->ordersFacade->create(
                $cart,
                $values['name'],
                $values['email'],
                $values['phone'],
                $values['street'],
                $values['city'],
                $values['zip'],
                $values['country']
            );

            $this->cartsFacade->deleteCart($cart);

            $this->onSubmit();
        };
    }

    private function zipValidator(): \Closure
    {
        return function (TextInput $input) {
            return preg_match('~^[0-9]{5}$~', $input->value) === 1;
        };
    }

    private function phoneValidator(): \Closure
    {
        return function (TextInput $input) {
            return preg_match('~^\+420[0-9]{9}$~', $input->value) === 1;
        };
    }
}
