<?php
namespace Mia3\Expose\ViewHelpers\Form;

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
class FieldViewHelper extends AbstractViewHelper {

    /**
     * Disable escaping of tag based ViewHelpers so that the rendered tag is not htmlspecialchar'd
     *
     * @var boolean
     */
    protected $escapeOutput = FALSE;

    /**
     * Constructor
     *
     * @api
     */
    public function initializeArguments() {
        $this->registerArgument('name', 'string', 'Name of the form field', TRUE);
        $this->registerArgument('label', 'string', 'Label for the form field');
        $this->registerArgument('wrap', 'string', 'Default Wrap', FALSE, 'Default');
        $this->registerArgument('control', 'string', 'Default Control', FALSE, 'Textfield');
        $this->registerArgument('value', 'string', 'Default value', FALSE);
    }

    /**
     * @return string
     */
    public function render() {
        $arguments = $this->arguments;
        $content = $this->renderChildren();
        if (empty($content)) {
            $content = $this->viewHelperVariableContainer->getView()->renderPartial('Expose/Fields/' . ucfirst($this->arguments['control']), NULL, $this->arguments);
        }
        $arguments['control'] = $content;

        if (empty($this->arguments['wrap'])) {
            return $content;
        }
        return $this->viewHelperVariableContainer->getView()->renderPartial('Expose/Wraps/Default', NULL, $arguments);
    }

}
