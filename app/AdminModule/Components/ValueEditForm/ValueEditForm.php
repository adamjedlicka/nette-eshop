<?php

namespace App\AdminModule\Components\ValueEditForm;

use App\Model\Entities\Attribute;
use App\Model\Entities\Value;
use App\Model\Facades\AttributesFacade;
use App\Model\Facades\ValuesFacade;
use Exception;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nextras\FormsRendering\Renderers\Bs5FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;
use Tracy\Debugger;

class ValueEditForm extends Form
{
    /** @var callable[] */
    public $onSuccess;

    private ValuesFacade $valuesFacade;

    private AttributesFacade $attributesFacade;

    public function __construct(
        IContainer $parent = null,
        string $name = null,
        ValuesFacade $valuesFacade,
        AttributesFacade $attributesFacade,
    ) {
        parent::__construct($parent, $name);
        $this->valuesFacade = $valuesFacade;
        $this->attributesFacade = $attributesFacade;

        $this->setRenderer(new Bs5FormRenderer(FormLayout::VERTICAL));

        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $this->addHidden('id');

        $this->addHidden('attributeId');

        $this->addText('name', 'Name')
            ->setRequired('Name is required');

        $this->addSelect('attribute', 'Attribute', $this->getAttributes())
            ->setHtmlAttribute('data-custom-type', 'select2')
            ->setRequired('Attribute is required');

        $this->addSubmit('ok', 'Save')
            ->onClick[] = function () {

            $values = $this->getValues();

            if (!empty($values['id'])) {
                try {
                    $value = $this->valuesFacade->getValue($values['id']);
                } catch (Exception $e) {
                    Debugger::log($e);
                    return;
                }
            } else {
                $value = new Value();
            }

            $value->name = $values['name'];
            $value->attribute = $this->attributesFacade->getAttribute($values['attribute']);

            $this->valuesFacade->saveValue($value);

            $this->onSuccess();
        };
    }

    public function setDefaults($values, bool $erase = false): self
    {
        if ($values instanceof Value) {
            $values = [
                'id' => $values->id,
                'name' => $values->name,
            ];
        }

        parent::setDefaults($values, $erase);

        return $this;
    }

    private function getAttributes(): array
    {
        $attributes = [];

        foreach ($this->attributesFacade->findAttributes() as $attribute) {
            $attributes[$attribute->id] = $attribute->name;
        }

        return $attributes;
    }
}
