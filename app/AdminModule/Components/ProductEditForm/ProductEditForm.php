<?php

namespace App\AdminModule\Components\ProductEditForm;

use App\Model\Entities\Product;
use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\ProductsFacade;
use Exception;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nette\Utils\Strings;
use Nextras\FormsRendering\Renderers\Bs5FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;
use Tracy\Debugger;

class ProductEditForm extends Form
{
    /** @var callable[] */
    public $onSuccess;

    private ProductsFacade $productsFacade;

    private CategoriesFacade $categoriesFacade;

    public function __construct(
        IContainer $parent = null,
        string $name = null,
        ProductsFacade $productsFacade,
        CategoriesFacade $categoriesFacade,
    ) {
        parent::__construct($parent, $name);
        $this->productsFacade = $productsFacade;
        $this->categoriesFacade = $categoriesFacade;

        $this->setRenderer(new Bs5FormRenderer(FormLayout::VERTICAL));

        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $this->addHidden('id');

        $this->addText('name', 'Name')
            ->setRequired('Name is required');

        $this->addText('price', 'Price')
            ->addRule($this::FLOAT, 'Price has to be a number')
            ->setRequired('Price is required');

        $this->addText('slug', 'Url path')
            ->setHtmlAttribute('placeholder', 'Will be generated if left empty');

        $categories = [];

        foreach ($this->categoriesFacade->findCategories() as $category) {
            $categories[$category->id] = $category->name;
        }

        $this->addSelect('category', 'Category', $categories)
            ->setRequired('Category is required');

        $this->addSubmit('ok', 'Save')
            ->onClick[] = function () {

            $values = $this->getValues();

            if (!empty($values['id'])) {
                try {
                    $product = $this->productsFacade->getProduct($values['id']);
                } catch (Exception $e) {
                    Debugger::log($e);
                    return;
                }
            } else {
                $product = new Product();
            }

            $product->name = $values['name'];
            $product->price = (int) floor($values['price'] * 100);
            $product->slug = $values['slug'] !== '' ? $values['slug'] : Strings::webalize($values['name']);
            $product->category = $this->categoriesFacade->getCategory($values['category']);

            $this->productsFacade->saveProduct($product);

            $this->onSuccess();
        };
    }
}
