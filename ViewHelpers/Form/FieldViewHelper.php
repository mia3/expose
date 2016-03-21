<?php
namespace Mia3\Expose\ViewHelper\Form;

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
        $this->registerArgument('additionalAttributes', 'array', 'Additional tag attributes. They will be added directly to the resulting HTML tag.', FALSE);
        $this->registerArgument('data', 'array', 'Additional data-* attributes. They will each be added with a "data-" prefix.', FALSE);
    }

    /**
     * @return string
     */
    public function render() {
        var_dump('foobar');
//        return $this->tag->render();
    }

}
