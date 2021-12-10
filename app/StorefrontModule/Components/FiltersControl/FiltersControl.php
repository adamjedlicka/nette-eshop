<?php

namespace App\StorefrontModule\Components\FiltersControl;

use App\Model\Entities\Attribute;
use App\Model\Entities\Category;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nextras\FormsRendering\Renderers\Bs5FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;

class FiltersControl extends Form
{
    public function __construct(
        IContainer $parent = null,
        string $name = null,
    ) {
        parent::__construct($parent, $name);

        $this->setRenderer(new Bs5FormRenderer(FormLayout::VERTICAL));
    }

    public function createSubcomponents(Category $category, $selectedValues)
    {
        foreach ($category->attributes as $attribute) {
            $this->addSelect($attribute->id, $attribute->name, $this->getAllValues($attribute))
                ->setDefaultValue($this->getDefaultValue($attribute, $selectedValues));
        }

        $this->addSubmit('ok', 'Filter')
            ->onClick[] = function () {

            $values = [];

            foreach ($this->getValues() as $value) {
                if ($value > 0) $values[] = $value;
            }

            $this->onSuccess($values);
        };
    }

    private function getAllValues(Attribute $attribute): array
    {
        $values = [
            0 => '',
        ];

        foreach ($attribute->values as $value) {
            $values[$value->id] = $value->name;
        }

        return $values;
    }

    private function getDefaultValue(Attribute $attribute, $selectedValues)
    {
        if (!$selectedValues) return null;

        foreach ($attribute->values as $value) {
            if (in_array($value->id, $selectedValues)) return $value->id;
        }

        return null;
    }
}
