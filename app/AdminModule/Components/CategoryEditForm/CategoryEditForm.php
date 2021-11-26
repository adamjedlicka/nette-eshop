<?php

namespace App\AdminModule\Components\CategoryEditForm;

use App\Model\Entities\Category;
use App\Model\Entities\Slug;
use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\SlugsFacade;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nette\Forms\Controls\SubmitButton;
use Nette\SmartObject;
use Nextras\FormsRendering\Renderers\Bs5FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;

class CategoryEditForm extends Form
{
    use SmartObject;

    private CategoriesFacade $categoriesFacade;

    private SlugsFacade $slugsFacade;

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
        SlugsFacade $slugsFacade,
    ) {
        parent::__construct($parent, $name);
        $this->setRenderer(new Bs5FormRenderer(FormLayout::VERTICAL));
        $this->categoriesFacade = $categoriesFacade;
        $this->slugsFacade = $slugsFacade;
        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $id = $this->addHidden('id');
        $this->addText('name', 'Název kategorie')
            ->setRequired('Musíte zadat název kategorie');
        $this->addText('slug', 'URL')
            ->setRequired('Musíte zadat URL kategorie');
        $this->addTextArea('description', 'Popis kategorie')
            ->setRequired(false);
        $this->addSubmit('ok', 'uložit')
            ->onClick[] = function (SubmitButton $button) {
            $values = $this->getValues('array');
            if (!empty($values['id'])) {
                try {
                    $category = $this->categoriesFacade->getCategory($values['id']);
                    $slug = $category->slug;
                } catch (\Exception $e) {
                    $this->onFailed('Požadovaná kategorie nebyla nalezena.');
                    return;
                }
            } else {
                $slug = new Slug();
                $category = new Category();
            }
            $category->assign($values, ['name', 'description']);
            $this->categoriesFacade->saveCategory($category);
            $slug->value = $values['slug'];
            $slug->category = $category;
            $this->slugsFacade->saveSlug($slug);
            $this->setValues(['id' => $category->id]);
            $this->onFinished('Kategorie byla uložena.');
        };
        $this->addSubmit('storno', 'zrušit')
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
                'slug' => $values->slug->value,
            ];
        }
        parent::setDefaults($values, $erase);
        return $this;
    }
}
