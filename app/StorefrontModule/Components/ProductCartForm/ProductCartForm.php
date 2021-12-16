<?php

namespace App\StorefrontModule\Components\ProductCartForm;

use App\Model\Entities\Product;
use App\StorefrontModule\Components\CartControl\CartControl;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nette\Forms\Controls\SubmitButton;
use Nette\SmartObject;
use Nextras\FormsRendering\Renderers\Bs5FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;

class ProductCartForm extends Form
{
    use SmartObject;

    public $onFinished = [];

    public $onSubmit = [];

    public $onCancel = [];

    public function __construct(IContainer $parent = null, string $name = null)
    {
        parent::__construct($parent, $name);
        $this->setRenderer(new Bs5FormRenderer(FormLayout::VERTICAL));
        $this->createSubcomponents();
    }

    public function createSubcomponents()
    {
        $this->addHidden('id', '')
            ->setRequired('id must be set');

        $this->addInteger('quantity', '');

        $this->addSubmit('add', 'Add to cart')
            ->onClick[] = function (SubmitButton $button) {
            $this->onFinished();
        };

    }
}
