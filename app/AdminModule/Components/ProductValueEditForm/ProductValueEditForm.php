<?php

namespace App\AdminModule\Components\ProductValueEditForm;

use App\Model\Entities\Attribute;
use App\Model\Entities\Product;
use App\Model\Facades\ProductsFacade;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nette\Database\Context;
use Nextras\FormsRendering\Renderers\Bs5FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;

class ProductValueEditForm extends Form
{
    /** @var callable[] */
    public $onSuccess;

    private ProductsFacade $productsFacade;

    public function __construct(
        IContainer $parent = null,
        string $name = null,
        ProductsFacade $productsFacade,
    ) {
        parent::__construct($parent, $name);
        $this->productsFacade = $productsFacade;

        $this->setRenderer(new Bs5FormRenderer(FormLayout::VERTICAL));
    }

    public function createSubcomponents(Product $product)
    {
        foreach ($product->category->attributes as $attribute) {
            $this->addMultiSelect($attribute->id, $attribute->name, $this->getAllValues($attribute))
                ->setHtmlAttribute('data-custom-type', 'select2')
                ->setDefaultValue($this->getCurrentValues($product, $attribute));
        }

        $this->addSubmit('ok', 'Save')
            ->onClick[] = function () use (&$product) {

            $values = $this->getValues();

            $product->replaceAllValues($values);

            $this->productsFacade->saveProduct($product);

            $this->onSuccess();
        };
    }

    private function getAllValues(Attribute $attribute)
    {
        $values = [];

        foreach ($attribute->values as $value) {
            $values[$value->id] = $value->name;
        }

        return $values;
    }

    private function getCurrentValues(Product $product, Attribute $attribute)
    {
        $values = [];

        foreach ($product->values as $value) {
            if ($value->attribute->id != $attribute->id) continue;

            $values[] = $value->id;
        }

        return $values;
    }
}
