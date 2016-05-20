<?php

namespace Mia3\Expose\ViewHelpers\Form;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

class SelectViewHelper extends AbstractTagBasedViewHelper
{
    
    protected $tagName = "select";


    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerTagAttribute('size', 'string', 'Size of input field');
        $this->registerTagAttribute('disabled', 'string', 'Specifies that the input element should be disabled when the page loads');
        $this->registerArgument('optionValueField', 'string', 'If specified, will call the appropriate getter on each object to determine the value.');
        $this->registerArgument('optionLabelField', 'string', 'If specified, will call the appropriate getter on each object to determine the label.');
        $this->registerArgument('options', 'mixed', 'Associative array or object with internal IDs as key, and the values are displayed in the select box', true);
        $this->registerArgument('value','mixed','The default value');
    }

    /**
     * Renders a select field
     */
    public function render()
    {
        $labelField = $this->arguments['optionLabelField'];
        $valueField = $this->arguments['optionValueField'];
        $options = $this->arguments['options'];
        $selected = $this->arguments['value'];
        if(is_object($options) && !($options instanceof \Traversable)) {
            $options = iterator_to_array($options);
        }
        $content = '';
        foreach($options as $option) {
            if(is_array($option)) { // render associative array options
                $value = is_string($valueField) ? $option[$valueField] : $option[array_keys($option)[0]];
                $label = is_string($labelField) ? $option[$labelField] : $value;
                $content .= $this->renderOptionTag($value,$label, $value == $selected);
            } else { // render sequential array options
                $content .= $this->renderOptionTag($option,$option,$option == $selected);
            }
        }
        
        $this->tag->setContent($content);
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