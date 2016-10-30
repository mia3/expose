<?php

namespace Mia3\Expose\ViewHelpers\Link;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

class RouteViewHelper extends AbstractTagBasedViewHelper
{

    protected $tagName = "a";

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerTagAttribute('class', 'string', 'class of input field');
        $this->registerArgument('route','string','route to be used');
        $this->registerArgument('arguments','array','arguments used for the route replacements', FALSE, array());
    }

    /**
     * Renders a select field
     */
    public function render()
    {
        $route = $this->arguments['route'];
        foreach ($this->arguments['arguments'] as $search => $replace) {
            $route = str_replace('{' . $search . '}', $replace, $route);
        }
        $this->tag->addAttribute('href', $route);
        $this->tag->setContent($this->renderChildren());
        return $this->tag->render();

    }

    /**
     * Renders an option tag
     *
     * @param string $value
     * @param null | string $label
     * @param bool $selected
     * @return string
     */
    private function renderOptionTag($value,$label = null ,$selected = false)
    {
        $option = new TagBuilder("option");
        $option->addAttribute('value', $value);
        $option->setContent(!is_null($label) ? $label : $value);
        if($selected) {
            $option->addAttribute('selected','selected');
        }
        return $option->render();
    }
}