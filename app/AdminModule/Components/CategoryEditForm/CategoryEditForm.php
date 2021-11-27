<?php

namespace App\AdminModule\Components\CategoryEditForm;

use App\Model\Entities\Category;
use App\Model\Facades\CategoriesFacade;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nette\Forms\Controls\SubmitButton;
use Nette\SmartObject;
use Nette\Utils\Strings;
use Nextras\FormsRendering\Renderers\Bs5FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;

class CategoryEditForm extends Form
{
    use SmartObject;

    private CategoriesFacade $categoriesFacade;

    /** @var callable[] $onFinished */
    public $onFinished = [];
    /** @var callable[] $onFailed */
    public $onFailed = [];
    /** @var callable[] $onCancel */
    public $onCancel = [];

    public function __construct(
        IContainer $parent = null,
        string $name = null,
        CategoriesFacade $categoriesFacade,
    ) {
        parent::__construct($parent, $name);
        $this->setRenderer(new Bs5FormRenderer(FormLayout::VERTICAL));
        $this->categoriesFacade = $categoriesFacade;
        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $id = $this->addHidden('id');
        $this->addText('name', 'Name')
            ->setRequired('Name is required');
        $this->addTextArea('description', 'Description')
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
            $this->setValues(['id' => $category->id]);
            $this->onFinished('Category was saved');
        };
        $this->addSubmit('storno', 'Cancel')
            ->setValidationScope([$id])
            ->onClick[] = function (SubmitButton $button) {
            $this->onCancel();
        };
    }

    /**
     * Metoda pro nastavení výchozích hodnot formuláře
     * @param Category|array|object $values
     * @param bool $erase = false
     * @return $this
     */
    public function setDefaults($values, bool $erase = false): self
    {
        if ($values instanceof Category) {
            $values = [
                'id' => $values->id,
                'name' => $values->name,
                'description' => $values->description,
                'slug' => $values->slug,
            ];
        }
        parent::setDefaults($values, $erase);
        return $this;
    }
}
