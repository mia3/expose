<?php
namespace Mia3\Expose\ViewHelpers\Form;

use Mia3\Expose\Action\Form\FormField;
use Mia3\Expose\Reflection\ClassSchema;
use Mia3\Expose\Reflection\PropertySchema;
use Mia3\Expose\ViewHelpers\FormViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/*
 * This file belongs to the package "TYPO3 Fluid".
 * See LICENSE.txt that was shipped with this package.
 */

/**
 * Tag based view helper.
 * Should be used as the base class for all view helpers which output simple tags, as it provides some
 * convenience methods to register default attributes, ...
 *
 * @api
 */
class FieldViewHelper extends AbstractViewHelper
{

    /**
     * Disable escaping of tag based ViewHelpers so that the rendered tag is not htmlspecialchar'd
     *
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * @var array
     */
    protected $additionalArguments = [];

    /**
     * Constructor
     */
    public function initializeArguments()
    {
        $this->registerArgument('field', FormField::class, 'FormField to render', false);
        $this->registerArgument('name', 'string', 'Name of the form field', false);
        $this->registerArgument('value', 'string', 'Default value', false);
        $this->registerArgument('control', 'string', 'Specifies the control to use to render this field', false, null);
        $this->registerArgument('wrap', 'string', 'Specifies the wrap used to render the field', false, 'Default');
        $this->registerArgument('required', 'boolean', 'Specifies, if this form field is required', false, false);
        $this->registerArgument('arguments', 'array', 'additional arguments for the control', false, array());
        $this->registerArgument('data-error', 'string', 'custom data attribute for error messages', false, null);
        $this->registerArgument('label', 'string', 'custom label for the field', false, null);
    }

    /**
     * @return string
     */
    public function render()
    {
        /** @var FormField $formField */
        $formField = $this->arguments['field'];
        if (!$formField instanceof FormField) {
            $formField = new FormField($this->arguments['name'], $this->arguments);
        }

        $this->arguments['control'] = $this->renderControl($formField->getControl());

        if (empty($formField->getWrap())) {
            return $this->arguments['control'];
        }

        return $this->viewHelperVariableContainer->getView()->renderPartial('Expose/Wraps/Default', null,
            $this->arguments);
    }

    public function renderControl($control)
    {
        $content = $this->renderChildren();
        if (!empty($content)) {
            return $content;
        }
        $arguments = array_merge($this->arguments, $this->additionalArguments);

        return $this->viewHelperVariableContainer->getView()->renderPartial('Expose/Fields/' . ucfirst($control), null,
            $arguments);
    }

    /**
     * Merges the additional arguments with the registered arguments
     * @param array $arguments
     */
    public function handleAdditionalArguments(array $arguments)
    {
        $this->arguments = array_merge($this->arguments, $arguments);
    }

    /**
     * Just accept anything as additional arguments
     * @param array $arguments
     * @return bool
     */
    public function validateAdditionalArguments(array $arguments)
    {
        return true;
    }
}
