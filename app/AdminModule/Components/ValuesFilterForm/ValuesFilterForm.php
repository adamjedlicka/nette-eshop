<?php

namespace App\AdminModule\Components\ValuesFilterForm;

use App\Model\Facades\AttributesFacade;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nextras\FormsRendering\Renderers\Bs5FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;

class ValuesFilterForm extends Form
{
    public $selectedAttribute = null;

    private AttributesFacade $attributesFacade;

    public function __construct(
        IContainer $parent = null,
        string $name = null,
        AttributesFacade $attributesFacade,
    ) {
        parent::__construct($parent, $name);
        $this->attributesFacade = $attributesFacade;

        $this->setRenderer(new Bs5FormRenderer(FormLayout::INLINE));
    }

    public function createSubcomponents()
    {
        $this->addSelect('attribute', 'Attribute', $this->getAttributes())
            ->setDefaultValue($this->selectedAttribute);

        $this->addSubmit('ok', 'Filter')
            ->onClick[] = function () {

            $this->onSuccess($this->getValues());
        };
    }

    private function getAttributes()
    {
        $attributes = [null => null];

        foreach ($this->attributesFacade->findAttributes() as $attribute) {
            $attributes[$attribute->id] = $attribute->name;
        }

        return $attributes;
    }
}
