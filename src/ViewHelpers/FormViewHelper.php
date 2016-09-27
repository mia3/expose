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
use Mia3\Expose\Core\Expose;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;


/**
 */
class FormViewHelper extends AbstractTagBasedViewHelper {

    /**
     * @var string
     */
    protected $tagName = 'form';

    /**
     * Constructor
     */
    public function initializeArguments() {
        $this->registerArgument('action', 'string', 'submission target');
        $this->registerArgument('form', 'object', 'Form Object');
        $this->registerTagAttribute('method', 'string', 'form method', FALSE, 'post');
        $this->registerUniversalTagAttributes();
    }

    public function render() {
        $this->tag->addAttribute('action', $this->arguments['action']);
//        $this->viewHelperVariableContainer->addOrUpdate(self::class, 'object', $this->arguments['object']);
//        $this->viewHelperVariableContainer->addOrUpdate(self::class, 'objectName', $this->arguments['objectName']);
//        $this->templateVariableContainer->add('schema', Expose::classSchemaFactory()->createClassSchema($this->arguments['object']));
        $this->tag->setContent($this->renderChildren());
//        $this->templateVariableContainer->remove('schema');
        $output = $this->tag->render();
//        $this->viewHelperVariableContainer->remove(self::class, 'object');
//        $this->viewHelperVariableContainer->remove(self::class, 'objectName');
        return $output;
    }

}