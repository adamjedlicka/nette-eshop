<?php

namespace App\AdminModule\Components\CategoryEditForm;

use App\Model\Entities\Category;
use App\Model\Facades\AttributesFacade;
use App\Model\Facades\CategoriesFacade;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nette\Forms\Controls\SubmitButton;
use Nette\Utils\Strings;
use Nextras\FormsRendering\Renderers\Bs5FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;

class CategoryEditForm extends Form
{
    /** @var callable[] */
    public $onSuccess;

    private CategoriesFacade $categoriesFacade;

    private AttributesFacade $attributesFacade;

    public function __construct(
        IContainer $parent = null,
        string $name = null,
        CategoriesFacade $categoriesFacade,
        AttributesFacade $attributesFacade,
    ) {
        parent::__construct($parent, $name);
        $this->setRenderer(new Bs5FormRenderer(FormLayout::VERTICAL));
        $this->categoriesFacade = $categoriesFacade;
        $this->attributesFacade = $attributesFacade;

        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $this->addHidden('id');

        $this->addText('name', 'Name')
            ->setRequired('Name is required');

        $this->addTextArea('description', 'Description')
            ->setRequired(false);

        $this->addMultiSelect('attributes', 'Attributes', $this->getAttributes())
            ->setRequired(false);

        $this->addSubmit('ok', 'Save')
            ->onClick[] = function (SubmitButton $button) {

            $values = $this->getValues('array');

            if (!empty($values['id'])) {
                try {
                    $category = $this->categoriesFacade->getCategory($values['id']);
                } catch (\Exception $e) {
                    $this->onFailed('Requested category not found');
                    return;
                }
            } else {
                $category = new Category();
            }

            $category->assign($values, ['name', 'description']);
            $category->slug = Strings::webalize($values['name']);

            $this->categoriesFacade->saveCategory($category);
            $category->replaceAllAttributes($values['attributes']);
            $this->categoriesFacade->saveCategory($category);

            $this->onSuccess();
        };
    }

    public function setDefaults($values, bool $erase = false): self
    {
        if ($values instanceof Category) {
            $values = [
                'id' => $values->id,
                'name' => $values->name,
                'description' => $values->description,
                'slug' => $values->slug,
                'attributes' => $this->getSelectedAttributes($values),
            ];
        }

        parent::setDefaults($values, $erase);

        return $this;
    }

    private function getAttributes()
    {
        $attributes = [];

        foreach ($this->attributesFacade->findAttributes() as $attribute) {
            $attributes[$attribute->id] = $attribute->name;
        }

        return $attributes;
    }

    private function getSelectedAttributes(Category $category)
    {
        $attributes = [];

        foreach ($category->attributes as $attribute) {
            $attributes[] = $attribute->id;
        }

        return $attributes;
    }
}
