<?php
namespace Mia3\Expose\ViewHelpers;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flowpack.Expose".       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 */
class BlockViewHelper extends AbstractViewHelper  {
	
	/**
	 * NOTE: This property has been introduced via code migration to ensure backwards-compatibility.
	 * @see AbstractViewHelper::isOutputEscapingEnabled()
	 * @var boolean
	 */
	protected $escapeOutput = FALSE;

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('name', 'string', 'name of the block');
    }

	/**
	 *
	 * @return string Rendered string
	 */
	public function render() {
		if ($this->viewHelperVariableContainer->exists('Mia3\Expose\ViewHelpers\BlockViewHelper', $this->arguments['name'])) {
			$block = $this->viewHelperVariableContainer->get('Mia3\Expose\ViewHelpers\BlockViewHelper', $this->arguments['name']);
			return implode(chr(10), $block);
		}

	}
}