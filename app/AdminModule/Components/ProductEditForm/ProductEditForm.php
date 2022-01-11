<?php

namespace App\AdminModule\Components\ProductEditForm;

use App\Model\Entities\Product;
use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\ImagesFacade;
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

    private ImagesFacade $imagesFacade;

    public function __construct(
        IContainer $parent = null,
        string $name = null,
        ProductsFacade $productsFacade,
        CategoriesFacade $categoriesFacade,
        ImagesFacade $imagesFacade,
    ) {
        parent::__construct($parent, $name);
        $this->productsFacade = $productsFacade;
        $this->categoriesFacade = $categoriesFacade;
        $this->imagesFacade = $imagesFacade;

        $this->setRenderer(new Bs5FormRenderer(FormLayout::VERTICAL));

        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $this->addHidden('id');

        $this->addText('name', 'Name')
            ->setRequired('Name is required');

        $this->addText('excerpt', 'Excerpt')
            ->setHtmlAttribute('placeholder', 'Short description didsplayed on category listing')
            ->setRequired('Excerpt is required');

        $this->addTextArea('description', 'Description')
            ->setHtmlAttribute('data-custom-type', 'summernote')
            ->setRequired(false);

        $this->addText('price', 'Price')
            ->addRule(self::FLOAT, 'Price has to be a number')
            ->setRequired('Price is required');

        $this->addUpload('thumbnail', 'Thumbnail')
            ->addRule(self::IMAGE, 'Thumbnail must be JPEG, PNG, GIF or WebP')
            ->addRule(self::MAX_FILE_SIZE, 'Maximum size is 1 MB', 1024 * 1024)
            ->setRequired(false);

        $this->addText('slug', 'Url path')
            ->setHtmlAttribute('placeholder', 'Will be generated if left empty')
            ->setRequired(false);

        $this->addSelect('category', 'Category', $this->getCategories())
            ->setHtmlAttribute('data-custom-type', 'select2')
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
            $product->excerpt = $values['excerpt'];
            $product->description = $values['description'];
            $product->price = (int) floor($values['price'] * 100);
            if ($values['thumbnail']->hasFile()) {
                $product->thumbnail = $this->imagesFacade->save($values['thumbnail']);
            } elseif (empty($values['id'])) {
                $product->thumbnail = $this->imagesFacade->getPlaceholderImage();
            }
            $product->slug = $values['slug'] !== '' ? $values['slug'] : Strings::webalize($values['name']);
            $product->category = $this->categoriesFacade->getCategory($values['category']);

            $this->productsFacade->saveProduct($product);

            $this->onSuccess();
        };
    }

    public function setDefaults($values, bool $erase = false): self
    {
        if ($values instanceof Product) {
            $values = [
                'id' => $values->id,
                'name' => $values->name,
                'excerpt' => $values->excerpt,
                'slug' => $values->slug,
                'description' => $values->description,
                'price' => $values->price / 100,
                'category' => $values->category->id,
            ];
        }

        parent::setDefaults($values, $erase);

        return $this;
    }

    private function getCategories()
    {
        $categories = [];

        foreach ($this->categoriesFacade->findCategories() as $category) {
            $categories[$category->id] = $category->name;
        }

        return $categories;
    }
}
