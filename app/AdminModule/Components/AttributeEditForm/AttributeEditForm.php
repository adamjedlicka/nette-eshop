<?php

namespace App\AdminModule\Components\AttributeEditForm;

use App\Model\Entities\Attribute;
use App\Model\Facades\AttributesFacade;
use Exception;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nextras\FormsRendering\Renderers\Bs5FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;
use Tracy\Debugger;

class AttributeEditForm extends Form
{
    /** @var callable[] */
    public $onSuccess;

    private AttributesFacade $attributesFacade;

    public function __construct(
        IContainer $parent = null,
        string $name = null,
        AttributesFacade $attributesFacade,
    ) {
        parent::__construct($parent, $name);
        $this->attributesFacade = $attributesFacade;

        $this->setRenderer(new Bs5FormRenderer(FormLayout::VERTICAL));

        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $this->addHidden('id');

        $this->addText('name', 'Name')
            ->setRequired('Name is required');

        $this->addTextArea('description', 'Description')
            ->setRequired(false);

        $this->addSubmit('ok', 'Save')
            ->onClick[] = function () {

            $values = $this->getValues();

            if (!empty($values['id'])) {
                try {
                    $attribute = $this->attributesFacade->getAttribute($values['id']);
                } catch (Exception $e) {
                    Debugger::log($e);
                    return;
                }
            } else {
                $attribute = new Attribute();
            }

            $attribute->name = $values['name'];
            $attribute->description = $values['description'];

            $this->attributesFacade->saveAttribute($attribute);

            $this->onSuccess();
        };
    }

    public function setDefaults($values, bool $erase = false): self
    {
        if ($values instanceof Attribute) {
            $values = [
                'id' => $values->id,
                'name' => $values->name,
                'description' => $values->description,
            ];
        }

        parent::setDefaults($values, $erase);

        return $this;
    }
}
