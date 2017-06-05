<?php
namespace Mia3\Expose\ViewHelpers;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Mia3.Expose".           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */
use Mia3\Expose\Action\Form\FormField;
use Mia3\Expose\Core\Expose;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;


/**
 */
class FormViewHelper extends AbstractTagBasedViewHelper
{

    /**
     * @var string
     */
    protected $tagName = 'form';

    /**
     * Constructor
     */
    public function initializeArguments()
    {
        $this->registerArgument('action', 'string', 'submission target');
        $this->registerArgument('form', 'object', 'Form Object');
        $this->registerTagAttribute('method', 'string', 'form method', false, 'post');
        $this->registerUniversalTagAttributes();
    }

    public function render()
    {
        $this->tag->addAttribute('action', $this->arguments['action']);
        $hiddenFields = array();
        /** @var FormField $hiddenField */
        foreach ($this->arguments['form']->getHiddenFields() as $hiddenField) {
            $tag = new TagBuilder('input');
            $tag->addAttributes([
                'type' => 'hidden',
                'name' => $hiddenField->getName(),
                'value' => $hiddenField->getValueOrDefault(),
            ]);
            $hiddenFields[] = $tag->render();
        }
        $content = implode(chr(10), $hiddenFields) . chr(10) . $this->renderChildren();
        $this->tag->setContent($content);
        $output = $this->tag->render();

        return $output;
    }

}