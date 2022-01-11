<?php

namespace App\AdminModule\Components\CmsPageEditForm;

use App\Model\Entities\CmsPage;
use App\Model\Facades\CmsPageFacade;
use Exception;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nette\Utils\Strings;
use Nextras\FormsRendering\Renderers\Bs5FormRenderer;
use Nextras\FormsRendering\Renderers\FormLayout;
use Tracy\Debugger;

class CmsPageEditForm extends Form
{
    private CmsPageFacade $cmsPageFacade;

    public function __construct(
        IContainer $parent = null,
        string $name = null,
        CmsPageFacade $cmsPageFacade,
    ) {
        parent::__construct($parent, $name);
        $this->cmsPageFacade = $cmsPageFacade;

        $this->setRenderer(new Bs5FormRenderer(FormLayout::VERTICAL));

        $this->createSubcomponents();
    }

    private function createSubcomponents()
    {
        $this->addHidden('id');

        $this->addText('name', 'Name')
            ->setRequired('Name is required');

        $this->addText('slug', 'Url path')
            ->setHtmlAttribute('placeholder', 'Will be generated if left empty')
            ->setRequired(false);

        $this->addTextArea('content', 'Content')
            ->setHtmlAttribute('data-custom-type', 'summernote')
            ->setRequired('Content is required');

        $this->addSubmit('ok', 'Save')
            ->onClick[] = function () {

            $values = $this->getValues();

            if (!empty($values['id'])) {
                try {
                    $cmsPage = $this->cmsPageFacade->getCmsPage($values['id']);
                } catch (Exception $e) {
                    Debugger::log($e);
                    return;
                }
            } else {
                $cmsPage = new CmsPage();
            }

            $cmsPage->name = $values['name'];
            $cmsPage->slug = $values['slug'] !== '' ? $values['slug'] : Strings::webalize($values['name']);
            $cmsPage->content = $values['content'];

            $this->cmsPageFacade->saveCmsPage($cmsPage);

            $this->onSuccess();
        };
    }

    public function setDefaults($values, bool $erase = false): self
    {
        if ($values instanceof CmsPage) {
            $values = [
                'id' => $values->id,
                'name' => $values->name,
                'slug' => $values->slug,
                'content' => $values->content,
            ];
        }

        parent::setDefaults($values, $erase);

        return $this;
    }
}
