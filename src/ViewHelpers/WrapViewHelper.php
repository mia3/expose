<?php
namespace Mia3\Expose\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 */
class WrapViewHelper extends AbstractViewHelper  {
    /**
     * NOTE: This property has been introduced via code migration to ensure backwards-compatibility.
     * @see AbstractViewHelper::isOutputEscapingEnabled()
     * @var boolean
     */
    protected $escapeOutput = FALSE;

	/**
	 * Constructor
	 *
	 * @api
	 */
	public function __construct() {
		$this->registerArgument('name', 'string', 'Name of the Wrapper', TRUE);
		$this->registerArgument('arguments', 'array', 'Arguments supplied to the callback applying this wrapper', FALSE, array());
	}

	/**
	 *
	 * @return string Rendered string
	 */
	public function render() {
		$content = $this->renderChildren();
		if ($this->viewHelperVariableContainer->exists('Flowpack\Expose\ViewHelpers\WrapViewHelper', $this->arguments['name'])) {
			$wraps = $this->viewHelperVariableContainer->get('Flowpack\Expose\ViewHelpers\WrapViewHelper', $this->arguments['name']);
			foreach ($wraps as $wrap) {
				$content = $wrap->wrap($content, $this->arguments['arguments']);
			}
		}
		return $content;
	}
}

?>